<?php

namespace App\Http\Controllers\Admin\WorkShifts;

use App\Http\Controllers\Controller;
use App\Http\Resources\WorkShift\WorkShiftsCollection;
use App\Services\WorkShifts\WorkShiftService;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __construct(
        public WorkShiftService $workShiftService
    )
    {
        
    }

    public function __invoke(Request $request)
    {
        $workShifts = $this->workShiftService->index($request);

        return response(new WorkShiftsCollection($workShifts));
    }
}
