<?php

namespace App\Http\Controllers\Admin\Clients;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Clients\BulkDeleteRequest;
use App\Models\Client;

class BulkDeleteController extends Controller
{
    public function __invoke(BulkDeleteRequest $request)
    {
        Client::destroy($request->ids);

        return response(['message' => 'OK',]);
    }
}
