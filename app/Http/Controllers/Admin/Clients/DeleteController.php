<?php

namespace App\Http\Controllers\Admin\Clients;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Services\Clients\ClientService;

class DeleteController extends Controller
{
    public function __construct(
        public ClientService $clientService
    )
    {
        
    }

    public function __invoke(Client $client)
    {
        $this->clientService->delete($client);

        return response(['message' => 'OK',]);
    }
}
