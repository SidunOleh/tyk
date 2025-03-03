<?php

namespace App\Http\Controllers\Admin\WorkShifts\Dispatchers;

use App\Http\Controllers\Controller;
use App\Models\DispatcherWorkShift;
use App\Services\WorkShifts\WorkShiftService;

class GetStatController extends Controller
{
    public function __construct(
        public WorkShiftService $workShiftService
    )
    {
        
    }

    public function __invoke(DispatcherWorkShift $dispatcherWorkShift)
    {
        $stat = $this->workShiftService->dispatcherWorkShiftStat($dispatcherWorkShift);

        return response(['stat' => $stat]);
    }
}
