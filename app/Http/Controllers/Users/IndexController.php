<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UsersCollection;
use App\Models\User;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $page = $request->query('page', 1);
        $perpage = $request->query('perpage', 15);
        $orderby = $request->query('orderby', 'created_at');
        $order = $request->query('order', 'DESC');
        $s = $request->query('s', '');
        $role = $request->query('role', []);

        $users = User::orderBy($orderby, $order)
            ->search($s)
            ->roles($role)
            ->paginate($perpage, ['*'], 'page', $page);

        return response(new UsersCollection($users));
    }
}
