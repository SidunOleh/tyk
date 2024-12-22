<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\BulkDeleteRequest;
use App\Services\Users\UserService;

class BulkDeleteController extends Controller
{
    public function __construct(
        public UserService $userService
    )
    {
        
    }

    public function __invoke(BulkDeleteRequest $request)
    {
        $this->userService->bulkDelete($request->ids);

        return response(['message' => 'OK',]);
    }
}
