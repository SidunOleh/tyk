<?php

namespace App\Http\Controllers\Couriers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Courier\CouriersCollection;
use App\Models\Courier;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $page = $request->query('page', 1);
        $perpage = $request->query('perpage', 15);
        $orderby = $request->query('orderby', 'created_at');
        $order = $request->query('order', 'DESC');
        $vehicles = $request->query('vehicles', []);
        $s = $request->query('s', '');

        $couriers = Courier::orderBy($orderby, $order)
            ->vehicles($vehicles)
            ->search($s)
            ->paginate($perpage, ['*'], 'page', $page);

        return response(new CouriersCollection($couriers));
    }
}
