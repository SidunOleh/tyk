<?php

namespace App\Services\WorkShifts;

use App\DTO\WorkShifts\Dispatchers\CloseDTO as DispatchersCloseDTO;
use App\DTO\WorkShifts\Dispatchers\OpenDTO as DispatchersOpenDTO;
use App\DTO\WorkShifts\Dispatchers\StatDTO as DispatchersStatDTO;
use App\DTO\WorkShifts\Drivers\CloseDTO;
use App\DTO\WorkShifts\Drivers\OpenDTO;
use App\DTO\WorkShifts\Drivers\StatDTO as DriversStatDTO;
use App\DTO\WorkShifts\Drivers\UpdateDTO;
use App\DTO\WorkShifts\StatDTO;
use App\DTO\WorkShifts\ZakladReports\UpdateDTO as ZakladReportsUpdateDTO;
use App\Events\DriverWorkShiftClosed;
use App\Exceptions\AlreadyHasOpenedWorkShiftException;
use App\Exceptions\AttachCarToNotOwnerException;
use App\Exceptions\HasOpenedDispatchersException;
use App\Exceptions\HasOpenedDriversException;
use App\Exceptions\WorkShiftIsAlreadyClosedException;
use App\Models\Car;
use App\Models\Courier;
use App\Models\DispatcherWorkShift;
use App\Models\DriverWorkShift;
use App\Models\WorkShift;
use App\Models\ZakladReport;
use App\Repositories\WorkShiftRepository;
use App\Services\Service;
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
        if (WorkShift::open()->count()) {
            throw new AlreadyHasOpenedWorkShiftException();
        }

        $workShift = WorkShift::create([
            'start' => now()->format('Y-m-d H:i:s'),
            'status' => WorkShift::OPEN,
        ]);

        return $workShift;
    }

    public function workShiftStat(WorkShift $workShift): StatDTO
    {
        return $this->workShiftRepository->getWorkShiftStat($workShift);
    }

    public function close(WorkShift $workShift): void
    {
        if ($workShift->status == WorkShift::CLOSE) {
            throw new WorkShiftIsAlreadyClosedException();
        }

        if (! $workShift->allDispatchersWorkShiftsClosed()) {
            throw new HasOpenedDispatchersException();
        }

        if (! $workShift->allDriversWorkShiftsClosed()) {
            throw new HasOpenedDriversException();
        }

        $stat = $this->workShiftRepository->getWorkShiftStat($workShift);

        $data = $stat->toArray();
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
        OpenDTO $dto
    ): DriverWorkShift
    {
        if (DriverWorkShift::open()->where('courier_id', $dto->courierId)->count()) {
            throw new AlreadyHasOpenedWorkShiftException();
        }

        $car = Car::find($dto->carId);

        if ($car->hasOwner() and $car->owner->id != $dto->courierId) {
            throw new AttachCarToNotOwnerException();
        }

        $driverWorkShift = $workShift->drivers()->create([
            'status' => DriverWorkShift::OPEN,
            'start' => $dto->start,
            'approximate_end' => $dto->approximateEnd,
            'courier_id' => $dto->courierId,
            'car_id' => $dto->carId,
            'exchange_office' => $dto->exchangeOffice,
        ]);

        return $driverWorkShift;
    }

    public function updateDriverWorkShift(
        DriverWorkShift $driverWorkShift,
        UpdateDTO $dto
    ): void
    {
        $car = Car::find($dto->carId);

        if ($car->hasOwner() and $car->owner->id != $driverWorkShift->courier_id) {
            throw new AttachCarToNotOwnerException();
        }

        $driverWorkShift->update([
            'status' => DriverWorkShift::OPEN,
            'start' => $dto->start,
            'approximate_end' => $dto->approximateEnd,
            'car_id' => $dto->carId,
            'exchange_office' => $dto->exchangeOffice,
        ]);
    }

    public function driverWorkShiftStat(
        DriverWorkShift $driverWorkShift
    ): DriversStatDTO
    {
        return $this->workShiftRepository->getDriverWorkShiftStat($driverWorkShift);
    }

    public function closeDriverWorkShift(
        DriverWorkShift $driverWorkShift,
        CloseDTO $dto
    ): void
    {
        if ($driverWorkShift->status == DriverWorkShift::CLOSE) {
            throw new WorkShiftIsAlreadyClosedException();
        }

        $data['end'] = $dto->end;
        $data['returned_amount'] = $dto->returnedAmount;
        $data['status'] = DriverWorkShift::CLOSE;

        $stat = $this->workShiftRepository->getDriverWorkShiftStat($driverWorkShift);

        $data = array_merge($data, $stat->toArray());

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
        DispatchersOpenDTO $dto
    ): DispatcherWorkShift
    {
        if (DispatcherWorkShift::open()->where('dispatcher_id', $dto->dispatcherId)->count()) {
            throw new AlreadyHasOpenedWorkShiftException();
        }

        $dispatcherWorkShift = $workShift->dispatchers()->create([
            'status' => DispatcherWorkShift::OPEN,
            'dispatcher_id' => $dto->dispatcherId,
            'start' => $dto->start,
        ]);

        return $dispatcherWorkShift;
    }

    public function dispatcherWorkShiftStat(
        DispatcherWorkShift $dispatcherWorkShift
    ): DispatchersStatDTO
    {
        return $this->workShiftRepository->getDispatcherWorkShiftStat($dispatcherWorkShift);
    }

    public function closeDispatcherWorkShift(
        DispatcherWorkShift $dispatcherWorkShift,
        DispatchersCloseDTO $dto
    ): void
    {
        if ($dispatcherWorkShift->status == DispatcherWorkShift::CLOSE) {
            throw new WorkShiftIsAlreadyClosedException();
        }

        $data['end'] = $dto->end;
        $data['status'] = DispatcherWorkShift::CLOSE;

        $dispatcherWorkShift->update($data);
    }

    public function updateZakladReport(
        ZakladReport $zakladReport, 
        ZakladReportsUpdateDTO $dto
    ): void
    {
        $zakladReport->update([
            'returned_amount'=> $dto->returnedAmount,
            'payment_method' => $dto->paymentMethod,
            'comment' => $dto->comment,
        ]);
    }    
}
