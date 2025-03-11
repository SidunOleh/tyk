<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Services\Settings\SettingsService;
use Illuminate\Http\Request;

class GetController extends Controller
{
    public function __construct(
        public SettingsService $settingsService
    )
    {
        
    }

    public function __invoke()
    {
        $settings = $this->settingsService->get();

        return response(['settings' => $settings]);
    }
}
