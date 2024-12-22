<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UsersCollection;
use App\Services\Users\UserService;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __construct(
        public UserService $userService
    )
    {
        
    }

    public function __invoke(Request $request)
    {
        $users = $this->userService->index($request);

        return response(new UsersCollection($users));
    }
}
