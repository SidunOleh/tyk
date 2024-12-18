<?php

namespace App\Http\Controllers\Admin\Clients;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Clients\UpdateRequest;
use App\Http\Resources\Client\ClientResource;
use App\Models\Client;

class UpdateController extends Controller
{
    public function __invoke(Client $client, UpdateRequest $request)
    {
        $client->update($request->validated());

        return response(['client' => new ClientResource($client),]);
    }
}
