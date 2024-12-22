<?php

namespace App\Http\Controllers\Admin\Clients;

use App\Http\Controllers\Controller;
use App\Http\Resources\Client\ClientsCollection;
use App\Services\Clients\ClientService;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __construct(
        public ClientService $clientService
    )
    {
        
    }

    public function __invoke(Request $request)
    {
        $clients = $this->clientService->index($request);

        return response(new ClientsCollection($clients));
    }
}
