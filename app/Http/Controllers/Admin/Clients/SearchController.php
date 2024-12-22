<?php

namespace App\Http\Controllers\Admin\Clients;

use App\Http\Controllers\Controller;
use App\Http\Resources\Client\ClientsSearchCollection;
use App\Services\Clients\ClientService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __construct(
        public ClientService $clientService
    )
    {
        
    }

    public function __invoke(Request $request)
    {        
        $clients = $this->clientService->search($request->query('s', ''));

        return response(new ClientsSearchCollection($clients));
    }
}
