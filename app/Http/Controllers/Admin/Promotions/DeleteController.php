<?php

namespace App\Http\Controllers\Admin\Promotions;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Services\Promotions\PromotionService;

class DeleteController extends Controller
{
    public function __construct(
        public PromotionService $promotionService
    )
    {
        
    }

    public function __invoke(Promotion $promotion)
    {
        $this->promotionService->delete($promotion);

        return response(['message' => 'OK',]);
    }
}
