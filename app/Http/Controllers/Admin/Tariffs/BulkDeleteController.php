<?php

namespace App\Http\Controllers\Admin\Tariffs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Tariffs\BulkDeleteRequest;
use App\Services\Tariffs\TariffService;

class BulkDeleteController extends Controller
{
    public function __construct(
        public TariffService $tariffService
    )
    {
        
    }

    public function __invoke(BulkDeleteRequest $request)
    {
        $this->tariffService->bulkDelete($request->ids);

        return response(['message' => 'OK']);
    }
}
