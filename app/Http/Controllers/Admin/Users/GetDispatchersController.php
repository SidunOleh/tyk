<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UsersSearchCollection;
use App\Services\Users\UserService;

class GetDispatchersController extends Controller
{
    public function __construct(
        public UserService $userService
    )
    {
        
    }

    public function __invoke()
    {
        $users = $this->userService->getDispatchers();

        return response(new UsersSearchCollection($users));
    }
}
