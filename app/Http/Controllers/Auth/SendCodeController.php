<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SendCodeRequest;
use App\Services\Auth\AuthService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
        } catch (ModelNotFoundException $e) {
            return response(['message' => 'Користувача з таким номером не існує.'], 400);
        } catch (Exception $e) {
            Log::error($e);

            return response(['message' => 'Помилка. Спробуйте ще раз.'], 400);
        }
    }
}
