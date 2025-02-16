<?php

namespace App\Http\Controllers\Admin\Regions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Regions\UpdateRequest;
use App\Http\Resources\Region\RegionResource;
use App\Models\Region;
use App\Services\Regions\RegionService;

class UpdateController extends Controller
{
    public function __construct(
        public RegionService $regionService
    )
    {
        
    }

    public function __invoke(Region $region, UpdateRequest $request)
    {
        $this->regionService->update($region, $request);

        return response(['region' => new RegionResource($region)]);
    }
}
