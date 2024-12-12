<?php

namespace App\Http\Controllers\Admin\Cashes;

use App\Http\Controllers\Controller;
use App\Models\Cash;

class DeleteController extends Controller
{
    public function __invoke(Cash $cash)
    {
        $cash->delete();

        return response(['message' => 'OK',]);
    }
}
