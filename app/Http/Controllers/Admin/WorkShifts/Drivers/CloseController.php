<?php

namespace App\Http\Controllers\Admin\WorkShifts\Drivers;

use App\DTO\WorkShifts\Drivers\CloseDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\WorkShifts\Drivers\CloseRequest;
use App\Models\DriverWorkShift;
use App\Services\WorkShifts\WorkShiftService;

class CloseController extends Controller
{
    public function __construct(
        public WorkShiftService $workShiftService
    )
    {
        
    }

    public function __invoke(DriverWorkShift $driverWorkShift, CloseRequest $request)
    {
        $this->workShiftService->closeDriverWorkShift($driverWorkShift, CloseDTO::createFromRequest($request));

        return response(['message' => 'OK']);
    }
}
