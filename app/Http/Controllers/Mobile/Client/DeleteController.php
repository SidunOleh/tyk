<?php

namespace App\Http\Controllers\Mobile\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DeleteController extends Controller
{
    public function __invoke()
    {
        $client = Auth::user();

        $client->delete();

        return response(['message' => 'OK']);
    }
}
