<?php

namespace App\Http\Controllers\Mobile\Client;

use App\DTO\Clients\UpdatePersonalInfoDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\Client\UpdatePersonalInfoRequest;
use App\Services\Clients\ClientService;
use Illuminate\Support\Facades\Auth;

class UpdatePersonalInfoController extends Controller
{
    public function __construct(
        public ClientService $clientService
    )
    {
        
    }

    public function __invoke(UpdatePersonalInfoRequest $request)
    {
        $this->clientService->updatePersonalInfo(
            Auth::user(), 
            new UpdatePersonalInfoDTO(
                $request->full_name,
                $request->phone
            )
        );

        return response(['message' => 'OK']);
    }
}
