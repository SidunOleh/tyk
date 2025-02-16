<?php

namespace App\Http\Controllers\Admin\Tariffs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Tariffs\UpdateRequest;
use App\Http\Resources\Tariff\TariffResource;
use App\Models\Tariff;
use App\Services\Tariffs\TariffService;

class UpdateController extends Controller
{
    public function __construct(
        public TariffService $tariffService
    )
    {
        
    }

    public function __invoke(Tariff $tariff, UpdateRequest $request)
    {
        $this->tariffService->update($tariff, $request);

        return response(['tariff' => new TariffResource($tariff)]);
    }
}
