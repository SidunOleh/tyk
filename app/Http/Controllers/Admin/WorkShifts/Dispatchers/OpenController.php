<?php

namespace App\Http\Controllers\Admin\WorkShifts\Dispatchers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\WorkShifts\Dispatchers\OpenRequest;
use App\Models\WorkShift;
use App\Services\WorkShifts\WorkShiftService;
use Illuminate\Http\Request;

class OpenController extends Controller
{
    public function __construct(
        public WorkShiftService $workShiftService
    )
    {
        
    }

    public function __invoke(WorkShift $workShift, OpenRequest $request)
    {
        $this->workShiftService->openDispatcherWorkShift($workShift, $request);

        return response(['message' => 'OK']);
    }
}
