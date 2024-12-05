<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UpdateRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

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
