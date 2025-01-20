<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Services\Clients\ClientService;
use Illuminate\Support\Facades\Auth;

class DeleteAccountController extends Controller
{
    public function __construct(
        public ClientService $clientService
    )
    {
        
    }

    public function __invoke()
    {
        $this->clientService->delete(Auth::guard('web')->user());

        return response(['message' => 'OK',]);
    }
}
