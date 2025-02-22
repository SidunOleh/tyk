<?php

namespace App\Http\Controllers\Admin\WorkShifts\Drivers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\WorkShifts\Drivers\UpdateRequest;
use App\Models\DriverWorkShift;
use App\Services\WorkShifts\WorkShiftService;

class UpdateController extends Controller
{
    public function __construct(
        public WorkShiftService $workShiftService
    )
    {
        
    }

    public function __invoke(DriverWorkShift $driverWorkShift, UpdateRequest $request)
    {
        $this->workShiftService->updateDriverWorkShift($driverWorkShift, $request);

        return response(['message' => 'OK']);
    }
}
