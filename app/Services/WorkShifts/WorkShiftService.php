<?php

namespace App\Services\WorkShifts;

use App\Http\Requests\Admin\WorkShifts\CloseRequest as WorkShiftsCloseRequest;
use App\Http\Requests\Admin\WorkShifts\Drivers\CloseRequest;
use App\Http\Requests\Admin\WorkShifts\Drivers\OpenRequest;
use App\Http\Requests\Admin\WorkShifts\Drivers\UpdateRequest;
use App\Http\Requests\Admin\WorkShifts\ZakladReports\UpdateRequest as ZakladReportsUpdateRequest;
use App\Models\Category;
use App\Models\DriverWorkShift;
use App\Models\Order;
use App\Models\WorkShift;
use App\Models\ZakladReport;
use App\Services\Service;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkShiftService extends Service
{
    protected string $model = WorkShift::class;

    public function current(): ?WorkShift
    {
        return WorkShift::open()
            ->with('drivers.courier')
            ->with('drivers.car')
            ->first();
    }

    public function open(): WorkShift
    {
        $workShift = WorkShift::create([
            'start' => now()->format('Y-m-d H:i:s'),
            'status' => 'open',
        ]);

        return $workShift;
    }

    public function openDriverWorkShift(
        WorkShift $workShift, 
        OpenRequest $request
    ): DriverWorkShift
    {
        $driverWorkShift = $workShift->drivers()->create([
            'status' => 'open',
            'start' => $request->start,
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
        $driverWorkShift->update($request->validated());
    }

    public function driverWorkShiftStat(
        DriverWorkShift $driverWorkShift
    ): array
    {
        $start = $driverWorkShift->start;
        $end = $driverWorkShift->end ?? now();

        $stat = [];
        $stat['food_shipping_count'] = 0;
        $stat['food_shipping_total'] = 0;
        $stat['shipping_count'] = 0;
        $stat['shipping_total'] = 0;
        $stat['taxi_count'] = 0;
        $stat['taxi_total'] = 0;

        $data = DB::table('orders')
            ->select(DB::raw('type, count(*) count, sum(total) total'))
            ->where('courier_id', $driverWorkShift->courier_id)
            ->whereBetween('created_at', [
                $start->format('Y-m-d H:i:s'), 
                $end->format('Y-m-d H:i:s'),
            ])
            ->whereNot('status', Order::CANCELED)
            ->groupBy('type')
            ->get();
            
        foreach ($data as $item) {
            $type = $item->type == Order::FOOD_SHIPPING
                ? 'food_shipping'
                : ($item->type == Order::SHIPPING 
                ? 'shipping' 
                : 'taxi');
            $stat["{$type}_count"] = (int) $item->count;
            $stat["{$type}_total"] = (float) $item->total;
        }
        
        $stat['additional_costs'] = (float) DB::table('orders')
            ->select(DB::raw('coalesce(sum(additional_costs), 0) additional_costs'))
            ->where('courier_id', $driverWorkShift->courier_id)
            ->whereBetween('created_at', [
                $start->format('Y-m-d H:i:s'), 
                $end->format('Y-m-d H:i:s'),
            ])
            ->whereNot('status', Order::CANCELED)
            ->first()
            ->additional_costs;

        $stat['to_returned'] = (float) DB::table('orders')
            ->select(DB::raw("coalesce(sum(total), 0) + {$driverWorkShift->exchange_office} - {$stat['additional_costs']} to_returned"))
            ->where('courier_id', $driverWorkShift->courier_id)
            ->whereBetween('created_at', [
                $start->format('Y-m-d H:i:s'), 
                $end->format('Y-m-d H:i:s'),
            ])
            ->where('payment_method', Order::CASH)
            ->whereNot('status', Order::CANCELED)
            ->first()
            ->to_returned;
        
        return $stat;
    }

    public function closeDriverWorkShift(
        DriverWorkShift $driverWorkShift,
        CloseRequest $request
    ): void
    {
        $data = $request->validated();
        $data['status'] = 'close';

        $driverWorkShift->update($data);
    }

    public function workShiftStat(
        WorkShift $workShift
    ): array
    {
        $start = $workShift->start;
        $end = $driverWorkShift->end ?? now();

        $stat = [];
        $stat['food_shipping_count'] = 0;
        $stat['food_shipping_total'] = 0;
        $stat['shipping_count'] = 0;
        $stat['shipping_total'] = 0;
        $stat['taxi_count'] = 0;
        $stat['taxi_total'] = 0;

        $data = DB::table('orders')
            ->select(DB::raw('type, count(*) count, sum(total) total'))
            ->whereBetween('created_at', [
                $start->format('Y-m-d H:i:s'), 
                $end->format('Y-m-d H:i:s'),
            ])
            ->whereNot('status', Order::CANCELED)
            ->groupBy('type')
            ->get();
        foreach ($data as $item) {
            $type = $item->type == Order::FOOD_SHIPPING
                ? 'food_shipping'
                : ($item->type == Order::SHIPPING 
                ? 'shipping' 
                : 'taxi');
            $stat["{$type}_count"] = (int) $item->count;
            $stat["{$type}_total"] = (float) $item->total;
        }
        
        return $stat;
    }

    public function close(
        WorkShift $workShift,
        WorkShiftsCloseRequest $request
    ): void
    {
        if (! $workShift->allDriversWorkShiftsClosed()) {
            throw new Exception('Закрийте зміни водіїв.');
        }

        $data = $request->validated();
        $data['status'] = 'close';
        $data['end'] = now()->format('Y-m-d H:i:s');

        $workShift->update($data);

        $zaklady = Category::establishment()->get();

        $data = DB::table('orders')
            ->select(DB::raw('category_product.category_id id, sum(order_items.quantity * order_items.amount) total'))
            ->join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->join('category_product', 'category_product.product_id', '=', 'products.id')
            ->whereBetween('orders.created_at', [
                $workShift->start->format('Y-m-d H:i:s'), 
                $workShift->end->format('Y-m-d H:i:s'),
            ])
            ->whereIn('category_product.category_id', $zaklady->pluck('id'))
            ->groupBy('category_product.category_id')
            ->get();

        foreach ($data as $item) {
            ZakladReport::create([
                'category_id' => $item->id,
                'work_shift_id' => $workShift->id,
                'total' => $item->total,
            ]);
        }
    }

    public function index(Request $request): LengthAwarePaginator
    {
        $page = $request->query('page', 1);
        $perpage = $request->query('perpage', 15);
        $orderby = $request->query('orderby', 'created_at');
        $order = $request->query('order', 'DESC');
        $s = $request->query('s', '');

        $models = WorkShift::with('zakladyReports')
            ->with('zakladyReports.zaklad')
            ->orderBy($orderby, $order)
            ->close()
            ->search($s)
            ->paginate($perpage, ['*'], 'page', $page);

        return $models;
    }

    public function updateZakladReport(
        ZakladReport $zakladReport, 
        ZakladReportsUpdateRequest $request
    ): void
    {
        $zakladReport->update($request->validated());
    }    
}
