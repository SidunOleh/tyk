<?php

namespace App\Http\Controllers\Cashes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cashes\UpdateRequest;
use App\Models\Cash;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    public function __invoke(Cash $cash, UpdateRequest $request)
    {
        $validated = $request->validated();

        $cash->update($validated);

        return response(['cash' => $cash,]);
    }
}
