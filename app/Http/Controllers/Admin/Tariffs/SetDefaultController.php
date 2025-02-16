<?php

namespace App\Http\Controllers\Admin\Tariffs;

use App\Http\Controllers\Controller;
use App\Models\Tariff;
use App\Services\Tariffs\TariffService;

class SetDefaultController extends Controller
{
    public function __construct(
        public TariffService $tariffService
    )
    {
        
    }

    public function __invoke(Tariff $tariff)
    {
        $this->tariffService->setAsDefault($tariff);

        return response(['message' => 'OK']);
    }
}
