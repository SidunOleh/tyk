<?php

namespace App\Http\Controllers\Clients;

use App\DTO\Clients\UpdatePersonalInfoDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Clients\UpdatePersonalInfoRequest;
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
            Auth::guard('web')->user(), 
            new UpdatePersonalInfoDTO(
                $request->full_name,
                $request->phone
            )
        );

        return response(['message' => 'OK',]);
    }
}
