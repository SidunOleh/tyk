<?php

namespace App\Services\Couriers;

use App\Models\Courier;
use App\Models\DriverWorkShift;
use App\Services\Mapon\MaponService;
use App\Services\Service;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class CourierService extends Service
{
    protected string $model = Courier::class;

    public function __construct(
        public MaponService $maponService
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
        $vehicles = $request->query('vehicles', []);

        $models = $this->model::orderBy($orderby, $order)
            ->search($s)
            ->vehicles($vehicles)
            ->paginate($perpage, ['*'], 'page', $page);

        return $models;
    }

    public function current(): Collection
    {
        $driversWorkShifts = DriverWorkShift::open()
            ->select('courier_id')
            ->get();

        $couriers = Courier::whereIn('id', $driversWorkShifts->pluck('courier_id'))->get();

        return $couriers;
    }

    public function getCurrentLocations(): array
    {
        $driversWorkShifts = DriverWorkShift::open()
            ->with('courier')
            ->with('car')
            ->get();
        $unitList = $this->maponService->getUnitList();
        $data = [];
        foreach ($driversWorkShifts as $driversWorkShift) {
            foreach ($unitList as $unitItem) {
                if (
                    $unitItem['unit_id'] == 
                    $driversWorkShift->car->mapon_id
                ) {
                    $item['courier']['id'] = 
                        $driversWorkShift->courier->id;
                    $item['courier']['first_name'] = 
                        $driversWorkShift->courier->first_name;
                    $item['courier']['last_name'] = 
                        $driversWorkShift->courier->last_name;
                    $item['car']['id'] = 
                        $driversWorkShift->car->id;
                    $item['car']['brand'] = 
                        $driversWorkShift->car->brand;
                    $item['car']['lat'] = $unitItem['lat'];
                    $item['car']['lng'] = $unitItem['lng'];
                    $item['car']['state'] = $unitItem['state']['name'];
                    $data[] = $item;
                }
            }
        }

        return $data;
    }
}