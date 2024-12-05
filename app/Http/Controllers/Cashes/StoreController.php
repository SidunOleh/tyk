<?php

namespace App\Http\Controllers\Cashes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cashes\StoreRequest;
use App\Models\Cash;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $validated = $request->validated();

        $cash = Cash::create($validated);

        return response(['cash' => $cash,]);
    }
}
