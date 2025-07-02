<?php

namespace App\Services\WorkShifts;

use App\Events\DriverWorkShiftClosed;
use App\Exceptions\AttachCarToNotOwnerException;
use App\Http\Requests\Admin\WorkShifts\CloseRequest as WorkShiftsCloseRequest;
use App\Http\Requests\Admin\WorkShifts\Dispatchers\CloseRequest as DispatchersCloseRequest;
use App\Http\Requests\Admin\WorkShifts\Drivers\CloseRequest;
use App\Http\Requests\Admin\WorkShifts\Drivers\OpenRequest;
use App\Http\Requests\Admin\WorkShifts\Drivers\UpdateRequest;
use App\Http\Requests\Admin\WorkShifts\ZakladReports\UpdateRequest as ZakladReportsUpdateRequest;
use App\Http\Requests\Admin\WorkShifts\Dispatchers\OpenRequest as DispatchersOpenRequest;
use App\Models\Car;
use App\Models\Courier;
use App\Models\DispatcherWorkShift;
use App\Models\DriverWorkShift;
use App\Models\WorkShift;
use App\Models\ZakladReport;
use App\Repositories\WorkShiftRepository;
use App\Services\Service;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class WorkShiftService extends Service
{
    protected string $model = WorkShift::class;

    public function __construct(
        public WorkShiftRepository $workShiftRepository
    )
    {
        
    }

    public function index(Request $request): LengthAwarePaginator
    {
        $page = $request->query('page', 1);
        $perpage = $request->query('perpage', 15);
        $orderby = $request->query('orderby', 'created_at');
        $order = $request->query('order', 'DESC');
        $s = $request->query('s', '');

        $models = WorkShift::with('drivers')
            ->with('drivers.courier')
            ->with('dispatchers')
            ->with('dispatchers.dispatcher')
            ->with('zakladyReports')
            ->with('zakladyReports.zaklad')
            ->close()
            ->search($s)
            ->orderBy($orderby, $order)
            ->paginate($perpage, ['*'], 'page', $page);

        return $models;
    }

    public function current(): ?WorkShift
    {
        return WorkShift::open()
            ->with('drivers')
            ->with('drivers.courier')
            ->with('drivers.car')
            ->with('dispatchers')
            ->with('dispatchers.dispatcher')
            ->first();
    }

    public function open(): WorkShift
    {
        $workShift = WorkShift::create([
            'start' => now()->format('Y-m-d H:i:s'),
            'status' => WorkShift::OPEN,
        ]);

        return $workShift;
    }

    public function workShiftStat(WorkShift $workShift): array
    {
        return $this->workShiftRepository->getWorkShiftStat($workShift);
    }

    public function close(
        WorkShift $workShift,
        WorkShiftsCloseRequest $request
    ): void
    {
        if (! $workShift->allDispatchersWorkShiftsClosed()) {
            throw new Exception('Закрийте зміни диспетчерів.');
        }

        if (! $workShift->allDriversWorkShiftsClosed()) {
            throw new Exception('Закрийте зміни водіїв.');
        }

        $data = $request->validated();
        $data['status'] = WorkShift::CLOSE;
        $data['end'] = now()->format('Y-m-d H:i:s');

        $workShift->update($data);

        $zakladyStat = $this->workShiftRepository->getStatByZaklady($workShift);

        foreach ($zakladyStat as $item) {
            ZakladReport::create([
                'category_id' => $item->zaklad_id,
                'work_shift_id' => $workShift->id,
                'total' => $item->total,
            ]);
        }
    }

    public function openDriverWorkShift(
        WorkShift $workShift, 
        OpenRequest $request
    ): DriverWorkShift
    {
        $car = Car::find($request->car_id);

        if ($car->hasOwner() and $car->owner->id != $request->courier_id) {
            throw new AttachCarToNotOwnerException();
        }

        $driverWorkShift = $workShift->drivers()->create([
            'status' => DriverWorkShift::OPEN,
            'start' => $request->start,
            'approximate_end' => $request->approximate_end,
            'courier_id' => $request->courier_id,
            'car_id' => $request->car_id,
            'exchange_office' => $request->exchange_office,
        ]);

        return $driverWorkShift;
    }

    public function updateDriverWorkShift(
        DriverWorkShift $driverWorkShift,
        UpdateRequest $request
    ): void
    {
        $car = Car::find($request->car_id);

        if ($car->hasOwner() and $car->owner->id != $driverWorkShift->courier_id) {
            throw new AttachCarToNotOwnerException();
        }

        $driverWorkShift->update($request->validated());
    }

    public function driverWorkShiftStat(
        DriverWorkShift $driverWorkShift
    ): array
    {
        return $this->workShiftRepository->getDriverWorkShiftStat($driverWorkShift);
    }

    public function closeDriverWorkShift(
        DriverWorkShift $driverWorkShift,
        CloseRequest $request
    ): void
    {
        $data = $request->validated();
        $data['status'] = DriverWorkShift::CLOSE;

        $driverWorkShift->update($data);

        DriverWorkShiftClosed::dispatch($driverWorkShift);
    }

    public function getOpenDriverWorkShift(Courier $courier): ?DriverWorkShift
    {
        $workShift = DriverWorkShift::with('courier')
            ->with('car')
            ->with('workShift')
            ->open()
            ->first();

        return $workShift;
    }

    public function getClosedDriverWorkShifts(Courier $courier, Request $request): LengthAwarePaginator
    {
        $page = $request->query('page', 1);
        $perpage = $request->query('perpage', 15);
        $orderby = $request->query('orderby', 'created_at');
        $order = $request->query('order', 'DESC');

        $models = DriverWorkShift::with('courier')
            ->with('car')
            ->with('workShift')
            ->close()
            ->courier($courier)
            ->orderBy($orderby, $order)
            ->paginate($perpage, ['*'], 'page', $page);

        return $models;
    }

    public function openDispatcherWorkShift(
        WorkShift $workShift,
        DispatchersOpenRequest $request
    ): DispatcherWorkShift
    {
        $dispatcherWorkShift = $workShift->dispatchers()->create([
            'status' => DispatcherWorkShift::OPEN,
            'dispatcher_id' => $request->dispatcher_id,
            'start' => $request->start,
        ]);

        return $dispatcherWorkShift;
    }

    public function dispatcherWorkShiftStat(
        DispatcherWorkShift $dispatcherWorkShift
    ): array
    {
        return $this->workShiftRepository->getDispatcherWorkShiftStat($dispatcherWorkShift);
    }

    public function closeDispatcherWorkShift(
        DispatcherWorkShift $dispatcherWorkShift,
        DispatchersCloseRequest $request
    ): void
    {
        $data = $request->validated();
        $data['status'] = DispatcherWorkShift::CLOSE;

        $dispatcherWorkShift->update($data);
    }

    public function updateZakladReport(
        ZakladReport $zakladReport, 
        ZakladReportsUpdateRequest $request
    ): void
    {
        $zakladReport->update($request->validated());
    }    
}
