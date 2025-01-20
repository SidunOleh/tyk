<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Requests\Clients\DeleteAddressRequest;
use App\Services\Clients\ClientService;
use Illuminate\Support\Facades\Auth;

class DeleteAddressController extends Controller
{
    public function __construct(
        public ClientService $clientService
    )
    {
        
    }

    public function __invoke(DeleteAddressRequest $request)
    {
        $client = Auth::guard('web')->user();

        $this->clientService->deleteAddress($client, $request);

        return response(['message' => 'OK',]);
    }
}
