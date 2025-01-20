<?php

namespace App\Http\Controllers\Admin\Promotions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Promotions\BulkDeleteRequest;
use App\Services\Promotions\PromotionService;

class BulkDeleteController extends Controller
{
    public function __construct(
        public PromotionService $promotionService
    )
    {
        
    }

    public function __invoke(BulkDeleteRequest $request)
    {
        $this->promotionService->bulkDelete($request->ids);

        return response(['message' => 'OK',]);
    }
}
