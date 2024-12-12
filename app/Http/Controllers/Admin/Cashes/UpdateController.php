<?php

namespace App\Http\Controllers\Admin\Cashes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Cashes\UpdateRequest;
use App\Models\Cash;

class UpdateController extends Controller
{
    public function __invoke(Cash $cash, UpdateRequest $request)
    {
        $validated = $request->validated();

        $cash->update($validated);

        return response(['cash' => $cash,]);
    }
}
