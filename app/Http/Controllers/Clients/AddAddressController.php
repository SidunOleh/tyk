<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Requests\Clients\AddAddressRequest;
use App\Services\Clients\ClientService;
use Illuminate\Support\Facades\Auth;

class AddAddressController extends Controller
{
    public function __construct(
        public ClientService $clientService
    )
    {
        
    }

    public function __invoke(AddAddressRequest $request)
    {
        $client = Auth::guard('web')->user();

        $this->clientService->addAddress($client, $request);

        return response(['message' => 'OK',]);
    }
}
