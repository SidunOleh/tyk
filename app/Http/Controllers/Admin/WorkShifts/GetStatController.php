<?php

namespace App\Http\Controllers\Admin\WorkShifts;

use App\Http\Controllers\Controller;
use App\Models\WorkShift;
use App\Services\WorkShifts\WorkShiftService;

class GetStatController extends Controller
{
    public function __construct(
        public WorkShiftService $workShiftService
    )
    {
        
    }

    public function __invoke(WorkShift $workShift)
    {
        $stat = $this->workShiftService->workShiftstat($workShift);

        return response(['stat' => $stat->toArray()]);
    }
}
