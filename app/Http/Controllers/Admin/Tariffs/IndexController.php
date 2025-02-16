<?php

namespace App\Http\Controllers\Admin\Tariffs;

use App\Http\Controllers\Controller;
use App\Http\Resources\Tariff\TariffsCollection;
use App\Services\Tariffs\TariffService;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __construct(
        public TariffService $tariffService
    )
    {
        
    }

    public function __invoke(Request $request)
    {
        $tariffs = $this->tariffService->index($request);

        return response(new TariffsCollection($tariffs));
    }
}
