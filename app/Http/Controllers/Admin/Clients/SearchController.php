<?php

namespace App\Http\Controllers\Admin\Clients;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Controller\Admin;
use App\Http\Resources\Client\ClientsSearchCollection;
use App\Models\Client;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $s = $request->query('s', '');
        
        if ($s) {
            $clients = Client::search($s)->get();
        } else {
            $clients = [];
        }

        return response(new ClientsSearchCollection($clients));
    }
}
