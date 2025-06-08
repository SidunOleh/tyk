<?php

namespace App\Http\Controllers\Admin\Driver;

use App\Http\Controllers\Controller;
use App\Services\WorkShifts\WorkShiftService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkShiftsController extends Controller
{
    public function __construct(
        public WorkShiftService $workShiftService
    )
    {
        
    }

    public function __invoke(Request $request)
    {
        $user = Auth::user();

        $workShifts = $this->workShiftService->getClosedDriverWorkShifts(
            $user->courier,
            $request
        );

        return response($workShifts);
    }
}
