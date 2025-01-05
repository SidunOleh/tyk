<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;

class EstablishmentsController extends Controller
{
    public function __invoke()
    {
        return view('pages.establishments');
    }
}
