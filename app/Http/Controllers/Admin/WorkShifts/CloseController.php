<?php

namespace App\Http\Controllers\Admin\WorkShifts;

use App\Exceptions\HasOpenedDispatchersException;
use App\Exceptions\HasOpenedDriversException;
use App\Http\Controllers\Controller;
use App\Http\Resources\WorkShift\WorkShiftResource;
use App\Models\WorkShift;
use App\Services\WorkShifts\WorkShiftService;

class CloseController extends Controller
{
    public function __construct(
        public WorkShiftService $workShiftService
    )
    {
        
    }

    public function __invoke(WorkShift $workShift)
    {
        try {
            $this->workShiftService->close($workShift);

            return response(['work_shift' => new WorkShiftResource($workShift)]);
        } catch (HasOpenedDispatchersException $e) {
            return response(['message' => 'Закрийте зміни диспетчерів.'], 400);
        } catch (HasOpenedDriversException $e) {
            return response(['message' => 'Закрийте зміни водіїв.'], 400);
        }
    }
}
