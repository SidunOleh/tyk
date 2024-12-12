<?php

namespace App\Http\Controllers\Admin\Cashes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Cashes\StoreRequest;
use App\Models\Cash;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $validated = $request->validated();

        $cash = Cash::create($validated);

        return response(['cash' => $cash,]);
    }
}
