<?php

namespace App\Http\Controllers\Couriers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Couriers\BulkDeleteRequest;
use App\Models\Courier;
use Illuminate\Http\Request;

class BulkDeleteController extends Controller
{
    public function __invoke(BulkDeleteRequest $request)
    {
        Courier::destroy($request->ids);

        return response(['message' => 'OK',]);
    }
}
