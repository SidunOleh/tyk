<?php

namespace App\Http\Controllers\Mobile\Auth;

use App\Exceptions\NotFoundClientByCodeException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\Auth\LogInRequest;
use App\Services\Auth\AuthService;

class LogInController extends Controller
{
    public function __construct(
        public AuthService $authService
    )
    {
        
    }

    public function __invoke(LogInRequest $request)
    {
        try {
            $token = $this->authService->loginMobile($request->code);

            return response(['token' => $token]);
        } catch (NotFoundClientByCodeException $e) {
            return response(['message' => 'Не знайдено.'], 404);
        }
    }
}
