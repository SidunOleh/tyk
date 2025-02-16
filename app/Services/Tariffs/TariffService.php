<?php

namespace App\Services\Tariffs;

use App\Models\Tariff;
use App\Services\Service;

class TariffService extends Service
{
    protected string $model = Tariff::class;

    public function setAsDefault(Tariff $tariff): void
    {
        Tariff::where(['default' => true])->update(['default' => false]);

        $tariff->update(['default' => true]);
    }
}