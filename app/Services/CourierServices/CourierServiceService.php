<?php

namespace App\Services\CourierServices;

use App\Models\CourierService;
use App\Services\Service;
use Illuminate\Database\Eloquent\Collection;

class CourierServiceService extends Service
{
    protected string $model = CourierService::class;

    public function visible(): Collection
    {
        return CourierService::visible()->get();
    }
}