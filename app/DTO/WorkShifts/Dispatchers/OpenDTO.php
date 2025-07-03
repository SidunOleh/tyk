<?php

namespace App\DTO\WorkShifts\Dispatchers;

use App\Http\Requests\Admin\WorkShifts\Dispatchers\OpenRequest;
use Carbon\Carbon;

class OpenDTO
{
    public function __construct(
        public int $dispatcherId,
        public Carbon $start
    )
    {
        
    }

    public static function createFromRequest(OpenRequest $request): self
    {
        return new self(
            $request->dispatcher_id,
            Carbon::createFromFormat('Y-m-d H:i:s', $request->start)
        );
    }
}