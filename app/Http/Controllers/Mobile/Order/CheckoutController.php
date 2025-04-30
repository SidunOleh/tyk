<?php

namespace App\Http\Controllers\Mobile\Order;

use App\DTO\Orders\CheckoutDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\Order\CheckoutRequest;
use App\Services\Categories\CategoryService;
use App\Services\Orders\FoodShippingService;

class CheckoutController extends Controller
{
    public function __construct(
        public FoodShippingService $orderService,
        public CategoryService $categoryService
    )
    {
        
    }

    public function __invoke(CheckoutRequest $request)
    {
        $productsIds = array_map(fn ($item) => $item['product_id'], $request->cart_items);

        if ($closed = $this->categoryService->closedZaklady($productsIds)) {
            return response(['message' => implode(', ', array_map(fn ($zaklad) => $zaklad->name, $closed)) . ' закритий. Повторіть замовлення в робочі години.'], 400);
        }

        $order = $this->orderService->checkout(
            new CheckoutDTO(
                $request->full_name,
                $request->phone,
                $request->address,
                $request->delivery_time,
                $request->notes,
                $request->payment_method,
                $request->use_bonuses,
                $request->cart_items,
            )
        );
        
        return response(['id' => $order->id]);
    }
}
