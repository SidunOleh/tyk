<?php

namespace App\Http\Controllers\Admin\Tariffs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Tariffs\StoreRequest;
use App\Http\Resources\Tariff\TariffResource;
use App\Services\Tariffs\TariffService;

class StoreController extends Controller
{
    public function __construct(
        public TariffService $tariffService
    )
    {
        
    }

    public function __invoke(StoreRequest $request)
    {
        $tariff = $this->tariffService->create($request);

        return response(['tariff' => new TariffResource($tariff)]);
    }
}
