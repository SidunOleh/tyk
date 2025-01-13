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
            return response(['message' => 'Неправильний код.'], 401);
        }

        return response(['message' => 'OK',]);
    }
}
