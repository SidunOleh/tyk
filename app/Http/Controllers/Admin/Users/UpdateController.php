<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\UpdateRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Services\Users\UserService;

class UpdateController extends Controller
{
    public function __construct(
        public UserService $userService
    )
    {
        
    }

    public function __invoke(User $user, UpdateRequest $request)
    {
        $this->userService->update($user, $request->validated());
        
        return response(['user' => new UserResource($user),]);
    }
}
