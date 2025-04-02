<?php

namespace App\Http\Controllers\Mobile\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\Auth\SendCodeRequest;
use App\Services\Auth\AuthService;

class SendCodeController extends Controller
{
    public function __construct(
        public AuthService $authService
    )
    {
        
    }

    public function __invoke(SendCodeRequest $request)
    {
        $this->authService->sendCode($request->phone);

        return response(['message' => 'OK']);
    }
}
