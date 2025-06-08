<?php

namespace App\Http\Controllers\Admin\Driver;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GetController extends Controller
{
    public function __construct()
    {
        
    }

    public function __invoke()
    {
        $user = Auth::user();
        $user->load(['courier']);

        return response(['driver' => $user,]);
    }
}
