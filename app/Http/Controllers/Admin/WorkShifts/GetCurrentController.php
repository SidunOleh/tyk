<?php

namespace App\Http\Controllers\Admin\WorkShifts;

use App\Http\Controllers\Controller;
use App\Http\Resources\WorkShift\WorkShiftResource;
use App\Services\WorkShifts\WorkShiftService;

class GetCurrentController extends Controller
{
    public function __construct(
        public WorkShiftService $workShiftService
    )
    {
        
    }

    public function __invoke()
    {
        $workShift = $this->workShiftService->current();

        return response(['work_shift' => $workShift ? new WorkShiftResource($workShift) : null]);
    }
}
