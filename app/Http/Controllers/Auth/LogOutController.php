<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LogOutController extends Controller
{
    public function __invoke()
    {
        Auth::logout();

        Session::invalidate();
        Session::regenerateToken();

        return response(['message' => 'OK',]);
    }
}
