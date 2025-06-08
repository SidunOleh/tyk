<?php

namespace App\Http\Controllers\Admin\Regions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Regions\StoreRequest;
use App\Http\Resources\Region\RegionResource;
use App\Services\Regions\RegionService;

class StoreController extends Controller
{
    public function __construct(
        public RegionService $regionService
    )
    {
        
    }

    public function __invoke(StoreRequest $request)
    {
        $region = $this->regionService->create($request->validated());

        return response(['region' => new RegionResource($region)]);
    }
}
