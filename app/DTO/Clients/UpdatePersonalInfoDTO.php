<?php

namespace App\DTO\Clients;

use App\DTO\BaseDTO;

class UpdatePersonalInfoDTO extends BaseDTO
{
    public function __construct(
        public string $fullName,
        public string $phone
    )
    {
        
    }
}