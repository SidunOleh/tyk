<?php

namespace App\Http\Controllers\Admin\Clients;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Clients\BulkDeleteRequest;
use App\Services\Clients\ClientService;

class BulkDeleteController extends Controller
{
    public function __construct(
        public ClientService $clientService
    )
    {
        
    }

    public function __invoke(BulkDeleteRequest $request)
    {
        $this->clientService->bulkDelete($request->ids);

        return response(['message' => 'OK',]);
    }
}
