<?php

namespace App\DTO\Clients;

class UpdatePersonalInfoDTO
{
    public function __construct(
        public string $fullName,
        public string $phone
    )
    {
        
    }
}