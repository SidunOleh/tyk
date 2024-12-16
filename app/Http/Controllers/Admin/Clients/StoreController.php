<?php

namespace App\Http\Controllers\Admin\Clients;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Clients\StoreRequest;
use App\Http\Resources\Client\ClientResource;
use App\Models\Client;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $client = Client::create($request->validated());

        return response(['client' => new ClientResource($client),]);
    }
}
