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
        $this->clientService->addAddress(Auth::guard('web')->user(), $request->address);

        return response(['message' => 'OK',]);
    }
}
