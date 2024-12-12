<?php

namespace App\Http\Controllers\Admin\Couriers;

use App\Http\Controllers\Controller;
use App\Models\Courier;

class DeleteController extends Controller
{
    public function __invoke(Courier $courier)
    {
        $courier->delete();

        return response(['message' => 'OK',]);
    }
}
