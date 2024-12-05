<?php

namespace App\Http\Controllers\Users;

use App\Events\UserCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\StoreRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $user = User::create($request->validated());

        UserCreated::dispatch($user, $request->password);

        return response(['user' => new UserResource($user),]);
    }
}
