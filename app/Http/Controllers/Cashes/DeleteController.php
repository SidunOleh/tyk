<?php

namespace App\Http\Controllers\Cashes;

use App\Http\Controllers\Controller;
use App\Models\Cash;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    public function __invoke(Cash $cash)
    {
        $cash->delete();

        return response(['message' => 'OK',]);
    }
}
