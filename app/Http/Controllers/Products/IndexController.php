<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Services\WC\Api;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __construct(
        private Api $wcAPI
    )
    {
        
    }

    public function __invoke(Request $request)
    {
        $page = $request->query('page', 1);
        $perpage = $request->query('perpage', 15);
        $orderby = $request->query('orderby', 'date');
        $order = $request->query('order', 'desc');
        $s = $request->query('s', '');

        $data = $this->wcAPI->products([
            'page' => $page,
            'per_page' => $perpage,
            'orderby' => $orderby,
            'order' => $order,
            'search' => $s,
        ]);

        return response($data);
    }
}
