<?php

namespace App\DTO\WorkShifts\ZakladReports;

use App\Http\Requests\Admin\WorkShifts\ZakladReports\UpdateRequest;

class UpdateDTO
{
    public function __construct(
        public int $returnedAmount,
        public string $paymentMethod,
        public ?string $comment,
    )
    {
        
    }

    public static function createFromRequest(UpdateRequest $request): self
    {
        return new self(
            $request->returned_amount,
            $request->payment_method,
            $request->comment
        );
    }
}