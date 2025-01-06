<?php

namespace App\Http\Controllers\Admin\Orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Orders\BulkDeleteRequest;
use App\Services\Orders\OrderService;

class BulkDeleteController extends Controller
{
    public function __invoke(BulkDeleteRequest $request)
    {
        OrderService::make('Таксі')->bulkDelete($request->ids);

        return response(['message' => 'OK',]);
    }
}
