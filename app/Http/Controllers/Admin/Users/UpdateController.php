<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\UpdateRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;

class UpdateController extends Controller
{
    public function __invoke(User $user, UpdateRequest $request)
    {
        $user->update($request->except(['password',]));

        if ($password = $request->password) {
            $user->update(['password' => $password,]);
        }
        
        return response(['user' => new UserResource($user),]);
    }
}
