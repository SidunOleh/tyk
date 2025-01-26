<?php

namespace App\Http\Controllers\Admin\Clients;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Clients\FindOrCreateRequest;
use App\Http\Resources\Client\ClientResource;
use App\Services\Clients\ClientService;

class FindOrCreateController extends Controller
{
    public function __construct(
        public ClientService $clientService
    )
    {
        
    }

    public function __invoke(FindOrCreateRequest $request)
    {
        $client = $this->clientService->findOrCreate($request);

        return response(['client' => new ClientResource($client)]);
    }
}
