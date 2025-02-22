<?php

namespace App\Http\Controllers\Admin\WorkShifts\Drivers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\WorkShifts\Drivers\OpenRequest;
use App\Models\WorkShift;
use App\Services\WorkShifts\WorkShiftService;

class OpenController extends Controller
{
    public function __construct(
        public WorkShiftService $workShiftService
    )
    {
        
    }

    public function __invoke(WorkShift $workShift, OpenRequest $request)
    {
        $this->workShiftService->openDriverWorkShift($workShift, $request);

        return response(['message' => 'OK']);
    }
}
