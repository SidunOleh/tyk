<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\BulkDeleteRequest;
use App\Models\User;

class BulkDeleteController extends Controller
{
    public function __invoke(BulkDeleteRequest $request)
    {
        User::destroy($request->ids);

        return response(['message' => 'OK',]);
    }
}
