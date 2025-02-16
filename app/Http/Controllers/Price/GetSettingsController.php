<?php

namespace App\Http\Controllers\Price;

use App\Http\Controllers\Controller;
use App\Services\Price\PriceService;

class GetSettingsController extends Controller
{
    public function __construct(
        public PriceService $priceService
    )
    {
        
    }

    public function __invoke()
    {
        $settings = $this->priceService->getSettings();

        return response(['settings' => $settings]);
    }
}
