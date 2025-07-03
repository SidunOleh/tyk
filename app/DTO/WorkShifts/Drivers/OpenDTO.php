<?php

namespace App\DTO\WorkShifts\Drivers;

use App\Http\Requests\Admin\WorkShifts\Drivers\OpenRequest;
use Carbon\Carbon;

class OpenDTO
{
    public function __construct(
        public int $courierId,
        public int $carId,
        public Carbon $start,
        public ?Carbon $approximateEnd,
        public float $exchangeOffice
    )
    {
        
    }

    public static function createFromRequest(OpenRequest $request): self
    {
        return new self(
            $request->courier_id,
            $request->car_id,
            Carbon::createFromFormat('Y-m-d H:i:s', $request->start),
            $request->approximate_end ? Carbon::createFromFormat('Y-m-d H:i:s', $request->approximate_end) : null,
            $request->exchange_office
        );
    }
}