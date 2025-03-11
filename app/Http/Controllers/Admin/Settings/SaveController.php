<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Settings\SaveRequest;
use App\Services\Settings\SettingsService;
use Illuminate\Http\Request;

class SaveController extends Controller
{
    public function __construct(
        public SettingsService $settingsService
    )
    {
        
    }

    public function __invoke(SaveRequest $request)
    {
        $this->settingsService->save($request);

        return response(['message' => 'OK']);
    }
}
