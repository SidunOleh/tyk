<?php

namespace App\Http\Controllers\Admin\Promotions;

use App\Http\Controllers\Controller;
use App\Http\Resources\Promotion\PromotionsCollection;
use App\Services\Promotions\PromotionService;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __construct(
        public PromotionService $promotionService
    )
    {
        
    }

    public function __invoke(Request $request)
    {
        $promotions = $this->promotionService->index($request);

        return response(new PromotionsCollection($promotions));
    }
}
