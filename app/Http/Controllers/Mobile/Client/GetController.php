<?php

namespace App\Http\Controllers\Mobile\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Client\ClientMobileResource;
use Illuminate\Support\Facades\Auth;

class GetController extends Controller
{
    public function __invoke()
    {
        $client = Auth::user();

        $client->load(['orders']);

        return response(new ClientMobileResource($client));
    }
}
