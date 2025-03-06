<?php

namespace App\Http\Controllers\Price;

use App\Http\Controllers\Controller;
use App\Http\Requests\Price\CalcForRouteRequest;
use App\Services\Price\PriceService;

class CalcForRouteController extends Controller
{
    public function __construct(
        public PriceService $priceService
    )
    {
        
    }

    public function __invoke(CalcForRouteRequest $request)
    {
        $price = $this->priceService->calcForRoute($request->validated());

        return response(['price' => $price]);
    }
}
