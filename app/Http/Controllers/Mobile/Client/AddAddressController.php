<?php

namespace App\Http\Controllers\Mobile\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\Client\AddAddressRequest;
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
        $this->clientService->addAddress(Auth::user(), $request->address);

        return response(['message' => 'OK']);
    }
}
