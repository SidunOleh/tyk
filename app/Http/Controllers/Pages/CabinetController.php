<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CabinetController extends Controller
{
    public function __invoke()
    {
        $client = Auth::guard('web')->user();

        return view('pages.cabinet', [
            'client' => $client,
        ]);
    }
}
