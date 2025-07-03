<?php

namespace App\DTO\WorkShifts\Dispatchers;

use App\Http\Requests\Admin\WorkShifts\Dispatchers\CloseRequest;
use Carbon\Carbon;

class CloseDTO
{
    public function __construct(
        public Carbon $end    
    )
    {
        
    }

    public static function createFromRequest(CloseRequest $request): self
    {
        return new self(
            Carbon::createFromFormat('Y-m-d H:i:s', $request->end)
        );
    }
}