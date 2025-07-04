<?php

namespace App\Services\Analytics;

use App\Exceptions\NotSupportedIntervalException;
use App\Models\Category;
use App\Models\Courier;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticsService
{
    public function income(
        string $start,
        string $end
    ): array
    {    
        $data = [];

        $data['data'] = DB::select($this->cteDateRange() . "
            SELECT dr.date date, SUM(IF(o.type = :type, o.subtotal + o.shipping_price, o.shipping_price)) total
            FROM date_range dr
            LEFT JOIN orders o
            ON dr.date = DATE(o.created_at)
            AND o.status != :status
            WHERE o.deleted_at IS NULL
            GROUP BY dr.date
            ORDER BY dr.date
        ", ['start' => $start, 'end' => $end, 'type' => Order::FOOD_SHIPPING, 'status' => Order::CANCELED,]);

        $data['total'] = DB::select("
            SELECT SUM(IF(type = :type, subtotal + shipping_price, shipping_price)) total
            FROM orders
            WHERE DATE(created_at) >= DATE(:start) AND DATE(created_at) <= DATE(:end)
            AND status != :status
            AND deleted_at IS NULL
        ", ['start' => $start, 'end' => $end, 'type' => Order::FOOD_SHIPPING, 'status' => Order::CANCELED,])[0]->total;

        $data['paid_by_cash'] = DB::select("
            SELECT SUM(IF(payment_method = :paid_by, IF(type = :food_shipping, subtotal + shipping_price, shipping_price), paid_by_cash)) total
            FROM orders
            WHERE DATE(created_at) >= DATE(:start) AND DATE(created_at) <= DATE(:end)
            AND payment_method IN (:cash, :combine)
            AND status != :canceled
            AND deleted_at IS NULL
        ", ['paid_by' => Order::CASH, 'cash' => Order::CASH, 'combine' => Order::COMBINE, 'start' => $start, 'end' => $end, 'food_shipping' => Order::FOOD_SHIPPING, 'canceled' => Order::CANCELED,])[0]->total;

        $data['paid_by_card'] = DB::select("
            SELECT SUM(IF(payment_method = :paid_by, IF(type = :food_shipping, subtotal + shipping_price, shipping_price), paid_by_card)) total
            FROM orders
            WHERE DATE(created_at) >= DATE(:start) AND DATE(created_at) <= DATE(:end)
            AND payment_method IN (:card, :combine)
            AND status != :canceled
            AND deleted_at IS NULL
        ", ['paid_by' => Order::CARD, 'card' => Order::CARD, 'combine' => Order::COMBINE, 'start' => $start, 'end' => $end, 'food_shipping' => Order::FOOD_SHIPPING, 'canceled' => Order::CANCELED,])[0]->total;

        $data['food_shipping_data'] = DB::select($this->cteDateRange() . "
            SELECT dr.date date, SUM(o.subtotal) total
            FROM date_range dr
            LEFT JOIN orders o
            ON dr.date = DATE(o.created_at)
            AND o.type = :type 
            AND o.status != :status
            AND o.deleted_at IS NULL
            GROUP BY dr.date
            ORDER BY dr.date
        ", ['start' => $start, 'end' => $end, 'type' => Order::FOOD_SHIPPING, 'status' => Order::CANCELED,]);

        $data['food_shipping_total'] = DB::select("
            SELECT SUM(subtotal) total
            FROM orders
            WHERE DATE(created_at) >= DATE(:start) AND DATE(created_at) <= DATE(:end)
            AND type = :type
            AND status != :status
            AND deleted_at IS NULL
        ", ['start' => $start, 'end' => $end, 'type' => Order::FOOD_SHIPPING, 'status' => Order::CANCELED,])[0]->total;

        $data['shipping_data'] = DB::select($this->cteDateRange() . "
            SELECT dr.date date, SUM(o.shipping_price) total
            FROM date_range dr
            LEFT JOIN orders o
            ON dr.date = DATE(o.created_at)
            AND o.type IN (:type_1, :type_2)
            AND o.status != :status
            AND o.deleted_at IS NULL
            GROUP BY dr.date
            ORDER BY dr.date
        ", ['start' => $start, 'end' => $end, 'type_1' => Order::FOOD_SHIPPING, 'type_2' => Order::SHIPPING, 'status' => Order::CANCELED,]);

        $data['shipping_total'] = DB::select("
            SELECT SUM(shipping_price) total
            FROM orders
            WHERE DATE(created_at) >= DATE(:start) AND DATE(created_at) <= DATE(:end)
            AND type IN (:type_1, :type_2)
            AND status != :status
            AND deleted_at IS NULL
        ", ['start' => $start, 'end' => $end, 'type_1' => Order::FOOD_SHIPPING, 'type_2' => Order::SHIPPING, 'status' => Order::CANCELED,])[0]->total;

        $data['taxi_data'] = DB::select($this->cteDateRange() . "
            SELECT dr.date date, SUM(o.shipping_price) total
            FROM date_range dr
            LEFT JOIN orders o
            ON dr.date = DATE(o.created_at)
            AND o.type = :type 
            AND o.status != :status
            AND o.deleted_at IS NULL
            GROUP BY dr.date
            ORDER BY dr.date
        ", ['start' => $start, 'end' => $end, 'type' => Order::TAXI, 'status' => Order::CANCELED,]);

        $data['taxi_total'] = DB::select("
            SELECT SUM(shipping_price) total
            FROM orders
            WHERE DATE(created_at) >= DATE(:start) AND DATE(created_at) <= DATE(:end)
            AND type = :type
            AND status != :status
            AND deleted_at IS NULL
        ", ['start' => $start, 'end' => $end, 'type' => Order::TAXI, 'status' => Order::CANCELED,])[0]->total;

        return $data;
    }

    public function orders(
        string $start,
        string $end
    ): array
    {    
        $data = [];

        $data['data'] = DB::select($this->cteDateRange() . "
            SELECT dr.date date, COUNT(o.id) total
            FROM date_range dr
            LEFT JOIN orders o
            ON dr.date = DATE(o.created_at)
            AND o.status != :status
            AND o.deleted_at IS NULL
            GROUP BY dr.date
            ORDER BY dr.date
        ", ['start' => $start, 'end' => $end, 'status' => Order::CANCELED,]);

        $data['total'] = DB::select("
            SELECT COUNT(id) total
            FROM orders
            WHERE DATE(created_at) >= DATE(:start) AND DATE(created_at) <= DATE(:end)
            AND status != :status
            AND deleted_at IS NULL
        ", ['start' => $start, 'end' => $end, 'status' => Order::CANCELED,])[0]->total;

        $data['food_shipping_data'] = DB::select($this->cteDateRange() . "
            SELECT dr.date date, COUNT(o.id) total
            FROM date_range dr
            LEFT JOIN orders o
            ON dr.date = DATE(o.created_at)
            AND o.type = :type 
            AND o.status != :status
            AND o.deleted_at IS NULL
            GROUP BY dr.date
            ORDER BY dr.date
        ", ['start' => $start, 'end' => $end, 'type' => Order::FOOD_SHIPPING, 'status' => Order::CANCELED,]);

        $data['food_shipping_total'] = DB::select("
            SELECT COUNT(id) total
            FROM orders
            WHERE DATE(created_at) >= DATE(:start) AND DATE(created_at) <= DATE(:end)
            AND type = :type
            AND status != :status
            AND deleted_at IS NULL
        ", ['start' => $start, 'end' => $end, 'type' => Order::FOOD_SHIPPING, 'status' => Order::CANCELED,])[0]->total;

        $data['shipping_data'] = DB::select($this->cteDateRange() . "
            SELECT dr.date date, COUNT(o.id) total
            FROM date_range dr
            LEFT JOIN orders o
            ON dr.date = DATE(o.created_at)
            AND o.type = :type 
            AND o.status != :status
            AND o.deleted_at IS NULL
            GROUP BY dr.date
            ORDER BY dr.date
        ", ['start' => $start, 'end' => $end, 'type' => Order::SHIPPING, 'status' => Order::CANCELED,]);

        $data['shipping_total'] = DB::select("
            SELECT COUNT(id) total
            FROM orders
            WHERE DATE(created_at) >= DATE(:start) AND DATE(created_at) <= DATE(:end)
            AND type = :type
            AND status != :status
            AND deleted_at IS NULL
        ", ['start' => $start, 'end' => $end, 'type' => Order::SHIPPING, 'status' => Order::CANCELED,])[0]->total;

        $data['taxi_data'] = DB::select($this->cteDateRange() . "
            SELECT dr.date date, COUNT(o.id) total
            FROM date_range dr
            LEFT JOIN orders o
            ON dr.date = DATE(o.created_at)
            AND o.type = :type 
            AND o.status != :status
            AND o.deleted_at IS NULL
            GROUP BY dr.date
            ORDER BY dr.date
        ", ['start' => $start, 'end' => $end, 'type' => Order::TAXI, 'status' => Order::CANCELED,]);

        $data['taxi_total'] = DB::select("
            SELECT COUNT(id) total
            FROM orders
            WHERE DATE(created_at) >= DATE(:start) AND DATE(created_at) <= DATE(:end)
            AND type = :type
            AND status != :status
            AND deleted_at IS NULL
        ", ['start' => $start, 'end' => $end, 'type' => Order::TAXI, 'status' => Order::CANCELED,])[0]->total;

        $data['source'] = DB::select("
            SELECT source, COUNT(*) total
            FROM orders
            WHERE DATE(created_at) >= DATE(:start) AND DATE(created_at) <= DATE(:end)
            AND source IS NOT NULL
            AND status != :canceled
            AND deleted_at IS NULL
            GROUP BY source
        ", ['start' => $start, 'end' => $end, 'canceled' => Order::CANCELED,]);

        return $data;
    }

    private function cteDateRange(): string
    {
        return "WITH RECURSIVE date_range AS (
            SELECT :start as date
            UNION ALL
            SELECT date + interval 1 day
            FROM date_range
            WHERE date < :end)";
    }
    
    public function products(
        string $start,
        string $end
    ): array
    {
        $data = [];

        $data['products_top'] = DB::select("
            SELECT p.name, SUM(o_i.quantity) quantity, SUM(o_i.amount * o_i.quantity) total
            FROM orders o
            JOIN order_items o_i
            ON o.id = o_i.order_id
            JOIN products p
            ON o_i.product_id = p.id
            WHERE DATE(o.created_at) >= DATE(:start) AND DATE(o.created_at) <= DATE(:end)
            AND o.status != :status
            AND o.deleted_at IS NULL
            AND o_i.deleted_at IS NULL
            GROUP BY o_i.product_id
            ORDER BY SUM(o_i.amount * o_i.quantity) DESC
            LIMIT 15
        ", ['start' => $start, 'end' => $end, 'status' => Order::CANCELED,]);

        $data['zaklady_top'] = DB::select("
            SELECT c.name, SUM(o_i.quantity) quantity, SUM(o_i.amount * o_i.quantity) total
            FROM orders o
            JOIN order_items o_i
            ON o.id = o_i.order_id
            JOIN category_product c_p
            ON o_i.product_id = c_p.product_id
            JOIN categories c
            ON c_p.category_id = c.id 
            AND c.parent_id IS NULL 
            AND c.name != :packaging
            WHERE DATE(o.created_at) >= DATE(:start) AND DATE(o.created_at) <= DATE(:end)
            AND o.status != :status
            AND o.deleted_at IS NULL
            AND o_i.deleted_at IS NULL
            GROUP BY c.id
            ORDER BY SUM(o_i.amount * o_i.quantity) DESC
        ", ['start' => $start, 'end' => $end, 'status' => Order::CANCELED, 'packaging' => Category::PACKAGING_NAME,]);

        return $data;
    }

    public function courierStatistic(Courier $courier, Carbon $start, Carbon $end, string $interval): array
    {
        $q = DB::table('orders')
            ->where('courier_id', $courier->id)
            ->whereNot('status', Order::CANCELED)
            ->whereNull('deleted_at');

        if ($interval == 'years') {
            $q->selectRaw('type, count(*) count, sum(shipping_price) total, YEAR(created_at) AS year')
                ->whereBetween(DB::raw('YEAR(created_at)'), [
                    $start->format('Y'),
                    $end->format('Y'),
                ])
                ->groupByRaw('type, YEAR(created_at)')
                ->orderByRaw('YEAR(created_at) ASC');
        } elseif ($interval == 'months') {
            $q->selectRaw('type, count(*) count, sum(shipping_price) total, YEAR(created_at) AS year, MONTH(created_at) AS month')
                ->whereBetween(DB::raw('YEAR(created_at)'), [
                    $start->format('Y'),
                    $end->format('Y'),
                ])
                ->whereBetween(DB::raw('MONTH(created_at)'), [
                    $start->format('m'),
                    $end->format('m'),
                ])
                ->groupByRaw('type, YEAR(created_at), MONTH(created_at)')
                ->orderByRaw('YEAR(created_at), MONTH(created_at) ASC');
        } elseif ($interval == 'days') {
            $q->selectRaw('type, count(*) count, sum(shipping_price) total, DATE(created_at) AS date')
                ->whereBetween(DB::raw('DATE(created_at)'), [
                    $start->format('Y-m-d'),
                    $end->format('Y-m-d'),
                ])
                ->groupByRaw('type, DATE(created_at)')
                ->orderByRaw('DATE(created_at) ASC');
        } else {
            throw new NotSupportedIntervalException();
        }

        $result = $q->get()->toArray();

        return $result;
    }
}