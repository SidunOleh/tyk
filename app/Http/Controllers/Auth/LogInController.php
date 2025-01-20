<?php

namespace App\Http\Controllers\Auth;

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
        $login = $this->authService->login($request->code);

        if (! $login) {
            return response(['errors' => ['code' => ['Неправильний код.',]]], 422);
        }

        return response(['message' => 'OK',]);
    }
}
