<?php

namespace App\Http\Controllers\Admin\Couriers;

use App\Http\Controllers\Controller;
use App\Services\Mapon\MaponService;

class GetCurrentLocationsController extends Controller
{
    public function __construct(
        public MaponService $maponService
    )
    {
        
    }

    public function __invoke()
    {
        $data = $this->maponService->getUnitList();

        return response($data['data']['units']);
    }
}
