<?php

namespace App\Http\Controllers\Admin\Regions;

use App\Http\Controllers\Controller;
use App\Http\Resources\Region\AllRegionsCollection;
use App\Services\Regions\RegionService;

class GetAllController extends Controller
{
    public function __construct(
        public RegionService $regionService
    )
    {
        
    }

    public function __invoke()
    {
        $regions = $this->regionService->all();

        return response(new AllRegionsCollection($regions));
    }
}
