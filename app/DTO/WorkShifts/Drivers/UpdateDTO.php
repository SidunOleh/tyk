<?php

namespace App\DTO\WorkShifts\Drivers;

use App\Http\Requests\Admin\WorkShifts\Drivers\UpdateRequest;
use Carbon\Carbon;

class UpdateDTO
{
    public function __construct(
        public int $carId,
        public Carbon $start,
        public ?Carbon $approximateEnd,
        public float $exchangeOffice
    )
    {
        
    }

    public static function createFromRequest(UpdateRequest $request): self
    {
        return new self(
            $request->car_id,
            Carbon::createFromFormat('Y-m-d H:i:s', $request->start),
            $request->approximate_end ? Carbon::createFromFormat('Y-m-d H:i:s', $request->approximate_end) : null,
            $request->exchange_office
        );
    }
}