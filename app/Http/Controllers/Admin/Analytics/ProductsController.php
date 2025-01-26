<?php

namespace App\Http\Controllers\Admin\Analytics;

use App\Http\Controllers\Controller;
use App\Services\Analytics\AnalyticsService;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function __construct(
        public AnalyticsService $analyticsService
    )
    {
        
    }

    public function __invoke(Request $request)
    {
        $data = $this->analyticsService->products(
            $request->start,
            $request->end
        );

        return response($data);
    }
}
