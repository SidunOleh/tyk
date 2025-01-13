<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class CompleteController extends Controller
{
    public function __invoke(Request $request)
    {
        $order = Order::findOrFail($request->query('order'));

        return view('pages.complete', [
            'order' => $order,
        ]);
    }
}
