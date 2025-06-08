<?php

namespace App\Http\Controllers\Admin\Driver;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Driver\ChangePasswordRequest;
use App\Services\Users\UserService;
use Illuminate\Support\Facades\Auth;

class ChangePasswordController extends Controller
{
    public function __construct(
        public UserService $userService
    )
    {
        
    }

    public function __invoke(ChangePasswordRequest $request)
    {
        $user = Auth::user();

        $this->userService->changePassword($user, $request->password);

        return response(['message' => 'OK',]);
    }
}
