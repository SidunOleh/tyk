<?php

namespace App\Http\Controllers\Admin\WorkShifts\ZakladReports;

use App\DTO\WorkShifts\ZakladReports\UpdateDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\WorkShifts\ZakladReports\UpdateRequest;
use App\Models\ZakladReport;
use App\Services\WorkShifts\WorkShiftService;

class UpdateController extends Controller
{
    public function __construct(
        public WorkShiftService $workShiftService
    )
    {
        
    }

    public function __invoke(ZakladReport $zakladReport, UpdateRequest $request)
    {
        $this->workShiftService->updateZakladReport($zakladReport, UpdateDTO::createFromRequest($request));

        return response(['message' => 'OK']);
    }
}
