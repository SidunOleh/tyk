<?php

namespace App\Http\Controllers\Admin\Promotions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Promotions\StoreRequest;
use App\Http\Resources\Promotion\PromotionResource;
use App\Services\Promotions\PromotionService;

class StoreController extends Controller
{
    public function __construct(
        public PromotionService $promotionService
    )
    {
        
    }

    public function __invoke(StoreRequest $request)
    {
        $promotion = $this->promotionService->create($request);

        return response(new PromotionResource($promotion));
    }
}
