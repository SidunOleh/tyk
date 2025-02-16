<?php

namespace App\Http\Controllers\Admin\Regions;

use App\Http\Controllers\Controller;
use App\Models\Region;
use App\Services\Regions\RegionService;

class DeleteController extends Controller
{
    public function __construct(
        public RegionService $regionService
    )
    {
        
    }

    public function __invoke(Region $region)
    {
        $this->regionService->delete($region);

        return response(['message' => 'OK']);
    }
}
