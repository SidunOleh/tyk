<?php

namespace App\Http\Controllers\Admin\Driver;

use App\Http\Controllers\Controller;
use App\Services\Analytics\AnalyticsService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatisticController extends Controller
{
    public function __construct(
        public AnalyticsService $analyticsService
    )
    {
        
    }

    public function __invoke(Request $request)
    {   
        $user = Auth::user();

        $start = Carbon::createFromFormat('Y-m-d', $request->query('start', now()->subDays(14)->format('Y-m-d')));
        $end = Carbon::createFromFormat('Y-m-d', $request->query('end', now()->format('Y-m-d')));
        $interval = $request->query('interval', 'days');

        $data = $this->analyticsService->courierStatistic(
            $user->courier,
            $start,
            $end,
            $interval
        );

        return response($data);
    }
}
