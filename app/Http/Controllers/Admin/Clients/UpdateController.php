<?php

namespace App\Http\Controllers\Admin\Clients;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Clients\UpdateRequest;
use App\Http\Resources\Client\ClientResource;
use App\Models\Client;
use App\Services\Clients\ClientService;

class UpdateController extends Controller
{
    public function __construct(
        public ClientService $clientService
    )
    {
        
    }

    public function __invoke(Client $client, UpdateRequest $request)
    {
        $this->clientService->update($client, $request->validated());

        return response(['client' => new ClientResource($client),]);
    }
}
