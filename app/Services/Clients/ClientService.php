<?php

namespace App\Services\Clients;

use App\Models\Client;
use App\Services\Service;

class ClientService extends Service
{
    protected string $model = Client::class;
}