<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\DispatcherWorkShift;
use App\Models\DriverWorkShift;
use App\Models\Order;
use App\Models\WorkShift;
use Illuminate\Support\Facades\DB;

class WorkShiftRepository 
{
    public function getWorkShiftStat(WorkShift $workShift): array
    {
        $stat = [];
        $stat['food_shipping_count'] = 0;
        $stat['food_shipping_total'] = 0;
        $stat['shipping_count'] = 0;
        $stat['shipping_total'] = 0;
        $stat['taxi_count'] = 0;
        $stat['taxi_total'] = 0;

        $start = $workShift->start;
        $end = $driverWorkShift->end ?? now();

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

    public function getStatByZaklady(WorkShift $workShift): array
    {
        $zaklady = Category::establishment()->get();

        $data = DB::table('orders')
            ->select(DB::raw('category_product.category_id zaklad_id, sum(order_items.quantity * order_items.amount) total'))
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

        return $data->toArray();
    }

    public function getDriverWorkShiftStat(DriverWorkShift $driverWorkShift): array
    {
        $stat = [];
        $stat['food_shipping_count'] = 0;
        $stat['food_shipping_total'] = 0;
        $stat['shipping_count'] = 0;
        $stat['shipping_total'] = 0;
        $stat['taxi_count'] = 0;
        $stat['taxi_total'] = 0;

        $start = $driverWorkShift->start;
        $end = $driverWorkShift->end ?? now();

        $data = DB::table('orders')
            ->select(DB::raw('type, count(*) count, sum(shipping_price) total'))
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

    public function getDispatcherWorkShiftStat(DispatcherWorkShift $dispatcherWorkShift): array
    {
        $stat = [];
        $stat['food_shipping_count'] = 0;
        $stat['food_shipping_total'] = 0;
        $stat['shipping_count'] = 0;
        $stat['shipping_total'] = 0;
        $stat['taxi_count'] = 0;
        $stat['taxi_total'] = 0;

        $start = $dispatcherWorkShift->start;
        $end = $driverWorkShift->end ?? now();

        $data = DB::table('orders')
            ->select(DB::raw('type, count(*) count, sum(total) total'))
            ->where('user_id', $dispatcherWorkShift->dispatcher_id)
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
}