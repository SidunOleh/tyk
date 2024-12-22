<?php

namespace App\Http\Controllers\Admin\Clients;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Clients\StoreRequest;
use App\Http\Resources\Client\ClientResource;
use App\Services\Clients\ClientService;

class StoreController extends Controller
{
    public function __construct(
        public ClientService $clientService
    )
    {
        
    }

    public function __invoke(StoreRequest $request)
    {
        $client = $this->clientService->create($request);

        return response(['client' => new ClientResource($client),]);
    }
}
