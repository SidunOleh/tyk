<?php

namespace App\Http\Controllers\Admin\Couriers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Couriers\BulkDeleteRequest;
use App\Models\Courier;

class BulkDeleteController extends Controller
{
    public function __invoke(BulkDeleteRequest $request)
    {
        Courier::destroy($request->ids);

        return response(['message' => 'OK',]);
    }
}
