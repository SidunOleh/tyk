<?php

namespace App\Http\Controllers\Couriers;

use App\Http\Controllers\Controller;
use App\Models\Courier;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    public function __invoke(Courier $courier)
    {
        $courier->delete();

        return response(['message' => 'OK',]);
    }
}
