<?php

namespace App\Http\Controllers\Admin\WorkShifts;

use App\Http\Controllers\Controller;
use App\Http\Resources\WorkShift\WorkShiftResource;
use App\Services\WorkShifts\WorkShiftService;

class OpenController extends Controller
{
    public function __construct(
        public WorkShiftService $workShiftService
    )
    {
        
    }

    public function __invoke()
    {
        $workShift = $this->workShiftService->open();

        return response(['work_shift' => new WorkShiftResource($workShift)]);
    }
}
