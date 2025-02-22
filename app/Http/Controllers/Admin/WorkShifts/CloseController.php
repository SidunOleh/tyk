<?php

namespace App\Http\Controllers\Admin\WorkShifts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\WorkShifts\CloseRequest;
use App\Http\Resources\WorkShift\WorkShiftResource;
use App\Models\WorkShift;
use App\Services\WorkShifts\WorkShiftService;
use Exception;

class CloseController extends Controller
{
    public function __construct(
        public WorkShiftService $workShiftService
    )
    {
        
    }

    public function __invoke(WorkShift $workShift, CloseRequest $request)
    {
        try {
            $this->workShiftService->close($workShift, $request);

            return response(['work_shift' => new WorkShiftResource($workShift)]);
        } catch (Exception $e) {
            return response(['message' => $e->getMessage()], 400);
        }
    }
}
