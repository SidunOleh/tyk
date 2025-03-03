<?php

namespace App\Http\Controllers\Admin\WorkShifts\Dispatchers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\WorkShifts\Dispatchers\CloseRequest;
use App\Models\DispatcherWorkShift;
use App\Services\WorkShifts\WorkShiftService;

class CloseController extends Controller
{
    public function __construct(
        public WorkShiftService $workShiftService
    )
    {
        
    }

    public function __invoke(DispatcherWorkShift $dispatcherWorkShift, CloseRequest $request)
    {
        $this->workShiftService->closeDispatcherWorkShift($dispatcherWorkShift, $request);

        return response(['message' => 'OK']);
    }
}
