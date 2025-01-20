<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;

class AboutUsController extends Controller
{
    public function __invoke()
    {
        return view('pages.about-us');
    }
}
