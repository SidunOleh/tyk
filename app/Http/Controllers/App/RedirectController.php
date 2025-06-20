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
            return redirect('https://apps.apple.com/ua/app/тук-тук-сервіс-твого-міста/id6745031284?l=uk');
        } else {
            return redirect('https://play.google.com/store/apps/details?id=com.tyktyk.tyktyk');
        }   
    }
}
