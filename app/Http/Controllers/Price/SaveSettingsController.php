<?php

namespace App\Http\Controllers\Price;

use App\Http\Controllers\Controller;
use App\Http\Requests\Price\SaveSettingsRequest;
use App\Services\Price\PriceService;

class SaveSettingsController extends Controller
{
    public function __construct(
        public PriceService $priceService
    )
    {
        
    }

    public function __invoke(SaveSettingsRequest $request)
    {
        $this->priceService->saveSettings($request);

        return response(['message' => 'OK']);
    }
}
