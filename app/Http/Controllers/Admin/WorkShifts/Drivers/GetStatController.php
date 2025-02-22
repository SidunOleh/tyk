<?php

namespace App\Http\Controllers\Admin\WorkShifts\Drivers;

use App\Http\Controllers\Controller;
use App\Models\DriverWorkShift;
use App\Services\WorkShifts\WorkShiftService;

class GetStatController extends Controller
{
    public function __construct(
        public WorkShiftService $workShiftService
    )
    {
        
    }

    public function __invoke(DriverWorkShift $driverWorkShift)
    {
        $stat = $this->workShiftService->driverWorkShiftStat($driverWorkShift);

        return response(['stat' => $stat]);
    }
}
