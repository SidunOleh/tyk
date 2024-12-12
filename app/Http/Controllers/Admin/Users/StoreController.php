<?php

namespace App\Http\Controllers\Admin\Users;

use App\Events\UserCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\StoreRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $user = User::create($request->validated());

        UserCreated::dispatch($user, $request->password);

        return response(['user' => new UserResource($user),]);
    }
}
