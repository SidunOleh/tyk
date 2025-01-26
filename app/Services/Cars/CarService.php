<?php

namespace App\Services\Cars;

use App\Models\Car;
use App\Services\Service;

class CarService extends Service
{
    protected string $model = Car::class;
}