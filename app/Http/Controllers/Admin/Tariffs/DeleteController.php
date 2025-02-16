<?php

namespace App\Http\Controllers\Admin\Tariffs;

use App\Http\Controllers\Controller;
use App\Models\Tariff;
use App\Services\Tariffs\TariffService;

class DeleteController extends Controller
{
    public function __construct(
        public TariffService $tariffService
    )
    {
        
    }

    public function __invoke(Tariff $tariff)
    {
        $this->tariffService->delete($tariff);

        return response(['message' => 'OK']);
    }
}
