<?php

namespace App\Repositories;

use App\DTO\WorkShifts\Dispatchers\StatDTO as DispatchersStatDTO;
use App\DTO\WorkShifts\Drivers\StatDTO as DriversStatDTO;
use App\DTO\WorkShifts\StatDTO;
use App\Models\Category;
use App\Models\DispatcherWorkShift;
use App\Models\DriverWorkShift;
use App\Models\Order;
use App\Models\WorkShift;
use Illuminate\Support\Facades\DB;

class WorkShiftRepository 
{
    public function getWorkShiftStat(WorkShift $workShift): StatDTO
    {
        $dto = new StatDTO();

        $start = $workShift->start;
        $end = $driverWorkShift->end ?? now();

        $data = DB::table('orders')
            ->select(DB::raw('type, count(*) count, sum(bonuses) bonuses, sum(total) total'))
            ->whereBetween('created_at', [
                $start->format('Y-m-d H:i:s'), 
                $end->format('Y-m-d H:i:s'),
            ])
            ->whereNot('status', Order::CANCELED)
            ->whereNull('deleted_at')
            ->groupBy('type')
            ->get();

        foreach ($data as $item) {
            if ($item->type == Order::FOOD_SHIPPING) {
                $dto->foodShippingCount = (int) $item->count;
                $dto->foodShippingTotal = (float) $item->total;
                $dto->foodShippingBonuses = (float) $item->bonuses;
            }

            if ($item->type == Order::SHIPPING) {
                $dto->shippingCount = (int) $item->count;
                $dto->shippingTotal = (float) $item->total;
                $dto->shippingBonuses = (float) $item->bonuses;
            }

            if ($item->type == Order::TAXI) {
                $dto->taxiCount = (int) $item->count;
                $dto->taxiTotal = (float) $item->total;
                $dto->taxiBonuses = (float) $item->bonuses;
            }
        }
        
        return $dto;
    }

    public function getStatByZaklady(WorkShift $workShift): array
    {
        $zaklady = Category::establishment()->get();

        $data = DB::table('orders')
            ->select(DB::raw('category_product.category_id zaklad_id, sum(order_items.quantity * order_items.amount + (select if(sum(packaging.quantity * packaging.amount), sum(packaging.quantity * packaging.amount), 0) from order_items as packaging where packaging.packaging_for = order_items.id)) total'))
            ->join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->join('category_product', 'category_product.product_id', '=', 'products.id')
            ->whereBetween('orders.created_at', [
                $workShift->start->format('Y-m-d H:i:s'), 
                $workShift->end->format('Y-m-d H:i:s'),
            ])
            ->whereNot('orders.status', Order::CANCELED)
            ->whereNull('orders.deleted_at')
            ->whereNull('order_items.deleted_at')
            ->whereIn('category_product.category_id', $zaklady->pluck('id'))
            ->groupBy('category_product.category_id')
            ->get();

        $addons = DB::table('orders')
            ->select(DB::raw('zaklad_addon_amounts.zaklad_id, sum(zaklad_addon_amounts.amount) addon_total'))
            ->join('zaklad_addon_amounts', 'zaklad_addon_amounts.order_id', '=', 'orders.id')
            ->whereBetween('orders.created_at', [
                $workShift->start->format('Y-m-d H:i:s'), 
                $workShift->end->format('Y-m-d H:i:s'),
            ])
            ->whereNot('orders.status', Order::CANCELED)
            ->whereNull('orders.deleted_at')
            ->groupBy('zaklad_addon_amounts.zaklad_id')
            ->get();

        foreach ($addons as $addon) {
            foreach ($data as $item) {
                if ($item->zaklad_id == $addon->zaklad_id) {
                    $item->total = (float) $item->total + (float) $addon->addon_total;
                }
            }
        }

        return $data->toArray();
    }

    public function getDriverWorkShiftStat(DriverWorkShift $driverWorkShift): DriversStatDTO
    {
        $dto = new DriversStatDTO();

        $start = $driverWorkShift->start;
        $end = $driverWorkShift->end ?? now();

        $data = DB::table('orders')
            ->select(DB::raw('type, count(*) count, sum(shipping_price) total, sum(bonuses) bonuses'))
            ->where('courier_id', $driverWorkShift->courier_id)
            ->whereBetween('created_at', [
                $start->format('Y-m-d H:i:s'), 
                $end->format('Y-m-d H:i:s'),
            ])
            ->whereNot('status', Order::CANCELED)
            ->whereNull('deleted_at')
            ->groupBy('type')
            ->get();
            
            foreach ($data as $item) {
                if ($item->type == Order::FOOD_SHIPPING) {
                    $dto->foodShippingCount = (int) $item->count;
                    $dto->foodShippingTotal = (float) $item->total;
                    $dto->foodShippingBonuses = (float) $item->bonuses;
                }
    
                if ($item->type == Order::SHIPPING) {
                    $dto->shippingCount = (int) $item->count;
                    $dto->shippingTotal = (float) $item->total;
                    $dto->shippingBonuses = (float) $item->bonuses;
                }
    
                if ($item->type == Order::TAXI) {
                    $dto->taxiCount = (int) $item->count;
                    $dto->taxiTotal = (float) $item->total;
                    $dto->taxiBonuses = (float) $item->bonuses;
                }
            }
        
        $result = DB::table('orders')
            ->select(DB::raw('coalesce(sum(additional_costs), 0) additional_costs'))
            ->where('courier_id', $driverWorkShift->courier_id)
            ->whereBetween('created_at', [
                $start->format('Y-m-d H:i:s'), 
                $end->format('Y-m-d H:i:s'),
            ])
            ->whereNot('status', Order::CANCELED)
            ->whereNull('deleted_at')
            ->first();
        
        $dto->additionalCosts = (float) $result->additional_costs;

        $result = DB::table('orders')
            ->select(DB::raw("coalesce(sum(if(payment_method = '".Order::CASH."', total, paid_by_cash) - bonuses), 0) + {$driverWorkShift->exchange_office} - {$dto->additionalCosts} to_returned"))
            ->where('courier_id', $driverWorkShift->courier_id)
            ->whereBetween('created_at', [
                $start->format('Y-m-d H:i:s'), 
                $end->format('Y-m-d H:i:s'),
            ])
            ->whereIn('payment_method', [Order::CASH, Order::COMBINE])
            ->whereNot('status', Order::CANCELED)
            ->whereNull('deleted_at')
            ->first();

        $dto->toReturned = (float) $result->to_returned;
        
        return $dto;
    }

    public function getDispatcherWorkShiftStat(DispatcherWorkShift $dispatcherWorkShift): DispatchersStatDTO
    {
        $dto = new DispatchersStatDTO();

        $start = $dispatcherWorkShift->start;
        $end = $driverWorkShift->end ?? now();

        $data = DB::table('orders')
            ->select(DB::raw('type, count(*) count, sum(total) total, sum(bonuses) bonuses'))
            ->where('user_id', $dispatcherWorkShift->dispatcher_id)
            ->whereBetween('created_at', [
                $start->format('Y-m-d H:i:s'), 
                $end->format('Y-m-d H:i:s'),
            ])
            ->whereNot('status', Order::CANCELED)
            ->whereNull('deleted_at')
            ->groupBy('type')
            ->get();
            
            foreach ($data as $item) {
                if ($item->type == Order::FOOD_SHIPPING) {
                    $dto->foodShippingCount = (int) $item->count;
                    $dto->foodShippingTotal = (float) $item->total;
                    $dto->foodShippingBonuses = (float) $item->bonuses;
                }
    
                if ($item->type == Order::SHIPPING) {
                    $dto->shippingCount = (int) $item->count;
                    $dto->shippingTotal = (float) $item->total;
                    $dto->shippingBonuses = (float) $item->bonuses;
                }
    
                if ($item->type == Order::TAXI) {
                    $dto->taxiCount = (int) $item->count;
                    $dto->taxiTotal = (float) $item->total;
                    $dto->taxiBonuses = (float) $item->bonuses;
                }
            }
        
        return $dto;
    }
}