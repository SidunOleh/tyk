<?php

namespace App\Services\Settings;

use App\Http\Requests\Admin\Settings\SaveRequest;
use App\Services\Options\OptionService;
use App\Services\Service;

class SettingsService extends Service
{
    public function __construct(
        private OptionService $optionService
    )
    {
        
    }

    public function get(): array
    {
        $settings = json_decode($this->optionService->get('main_settings'), true) ?? [];

        return [
            'bonuses_food_shipping' => 
                $settings['bonuses_food_shipping'] ?? 0,
            'bonuses_shipping' =>  
                $settings['bonuses_shipping'] ?? 0,
            'bonuses_taxi' => 
                $settings['bonuses_taxi'] ?? 0,
        ];
    }

    public function save(SaveRequest $request): void
    {
        $this->optionService->save('main_settings', json_encode($request->validated()));
    }
}