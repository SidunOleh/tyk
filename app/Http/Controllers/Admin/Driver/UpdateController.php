<?php

namespace App\Http\Controllers\Admin\Driver;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Driver\UpdateRequest;
use App\Services\Couriers\CourierService;
use App\Services\Users\UserService;
use Illuminate\Support\Facades\Auth;

class UpdateController extends Controller
{
    public function __construct(
        public CourierService $courierService,
        public UserService $userService
    )
    {
        
    }

    public function __invoke(UpdateRequest $request)
    {
        $user = Auth::user();

        $this->courierService->update($user->courier, $request->except([
            'email',
        ]));
        $this->userService->update($user, $request->only([
            'first_name',
            'last_name',
            'email',
            'phone',
        ]));

        $user->courier->refresh();

        return response(['driver' => $user,]);
    }
}
