<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SendResetLinkRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class SendResetLinkController extends Controller
{
    public function __invoke(SendResetLinkRequest $request)
    {
        $status = Password::sendResetLink($request->validated());

        return response(['message' =>__($status),], $status == Password::RESET_LINK_SENT ? 200 : 400);
    }
}
