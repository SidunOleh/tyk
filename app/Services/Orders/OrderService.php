<?php

namespace App\Services\Orders;

use App\Http\Requests\Admin\Orders\StoreRequest;
use App\Models\Order;
use Exception;

abstract class OrderService
{
    abstract public function createByAdmin(StoreRequest $request): Order;

    public static function make(string $type): self
    {
        switch ($type) {
            case 'Доставка їжі':
                return new FoodShippingService;
            case 'Кур\'єр':
                return new ShippingService;
            case 'Таксі':
                return new TaxiService;
            default:
                throw new Exception('Unexpected type: ' . $type);
        }
    }
}