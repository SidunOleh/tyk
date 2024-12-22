<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Users\UserService;

class DeleteController extends Controller
{
    public function __construct(
        public UserService $userService
    )
    {
        
    }

    public function __invoke(User $user)
    {
        $this->userService->delete($user);

        return response(['message' => 'OK',]);
    }
}
