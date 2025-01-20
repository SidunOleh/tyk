<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SendCodeRequest;
use App\Services\Auth\AuthService;
use Exception;
use Illuminate\Support\Facades\Log;

class SendCodeController extends Controller
{
    public function __construct(
        public AuthService $authService
    )
    {
        
    }

    public function __invoke(SendCodeRequest $request)
    {
        try {
            $this->authService->sendCode($request->phone);

            return response(['message' => 'OK',]);
        } catch (Exception $e) {
            Log::error($e);

            return response(['errors' => ['phone' => ['Помилка. Спробуйте ще раз.',]]], 422);
        }
    }
}
