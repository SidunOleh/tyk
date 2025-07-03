<?php

namespace App\DTO\WorkShifts\Drivers;

use App\Http\Requests\Admin\WorkShifts\Drivers\CloseRequest;
use Carbon\Carbon;

class CloseDTO
{
    public function __construct(
        public Carbon $end,
        public int $returnedAmount
    )
    {
        
    }

    public static function createFromRequest(CloseRequest $request): self
    {
        return new self(
            Carbon::createFromFormat('Y-m-d H:i:s', $request->end),
            $request->returned_amount
        );
    }
}