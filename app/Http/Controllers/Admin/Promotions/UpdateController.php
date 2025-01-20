<?php

namespace App\Http\Controllers\Admin\Promotions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Promotions\UpdateRequest;
use App\Http\Resources\Promotion\PromotionResource;
use App\Models\Promotion;
use App\Services\Promotions\PromotionService;

class UpdateController extends Controller
{
    public function __construct(
        public PromotionService $promotionService
    )
    {
        
    }

    public function __invoke(Promotion $promotion, UpdateRequest $request)
    {
        $this->promotionService->update($promotion, $request);

        return response(new PromotionResource($promotion));
    }
}
