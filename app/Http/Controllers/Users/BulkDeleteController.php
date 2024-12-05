<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\BulkDeleteRequest;
use App\Models\User;
use Illuminate\Http\Request;

class BulkDeleteController extends Controller
{
    public function __invoke(BulkDeleteRequest $request)
    {
        User::destroy($request->ids);

        return response(['message' => 'OK',]);
    }
}
