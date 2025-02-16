<?php

namespace App\Http\Controllers\Admin\Tariffs;

use App\Http\Controllers\Controller;
use App\Http\Resources\Tariff\AllTariffsCollection;
use App\Services\Tariffs\TariffService;

class GetAllController extends Controller
{
    public function __construct(
        public TariffService $tariffService
    )
    {
        
    }

    public function __invoke()
    {
        $tariffs = $this->tariffService->all();

        return response(new AllTariffsCollection($tariffs));
    }
}
