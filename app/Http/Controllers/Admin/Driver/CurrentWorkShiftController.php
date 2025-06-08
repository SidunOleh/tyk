<?php

namespace App\Http\Controllers\Admin\Driver;

use App\Http\Controllers\Controller;
use App\Services\WorkShifts\WorkShiftService;
use Illuminate\Support\Facades\Auth;

class CurrentWorkShiftController extends Controller
{
    public function __construct(
        public WorkShiftService $workShiftService
    )
    {
        
    }

    public function __invoke()
    {
        $user = Auth::user();

        $data['work_shift'] = $this->workShiftService->getOpenDriverWorkShift($user->courier);
        
        $data['statistic'] = null;
        if ($data['work_shift']) {
            $data['statistic'] = $this->workShiftService->driverWorkShiftStat($data['work_shift']);
        }

        return response($data);
    }
}
