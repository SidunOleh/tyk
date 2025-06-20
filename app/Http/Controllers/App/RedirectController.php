<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class RedirectController extends Controller
{
    public function __invoke(Request $request)
    {
        $agent = new Agent();
        $agent->setHttpHeaders($request->headers->all());

        if ($agent->is('iPhone')) {
            return redirect('https://apps.apple.com/ua/app/tyktyk/id1542962830');
        } else {
            return redirect('https://play.google.com/store/apps/details?id=com.tyktyk.tyktyk');
        }   
    }
}
