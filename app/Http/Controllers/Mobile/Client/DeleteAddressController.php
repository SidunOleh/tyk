<?php

namespace App\Http\Controllers\Mobile\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\Client\DeleteAddressRequest;
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
        $this->clientService->deleteAddress(Auth::user(), $request->index);

        return response(['message' => 'OK']);
    }
}
