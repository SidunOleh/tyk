<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\NotFoundClientByCodeException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LogInRequest;
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
            $this->authService->login($request->code);

            return response(['message' => 'OK',]);
        } catch (NotFoundClientByCodeException $e) {
            return response(['errors' => ['code' => ['Неправильний код.',]]], 422);
        }
    }
}
