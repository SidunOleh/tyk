<?php

namespace App\Services\Price;

use App\Http\Requests\Price\SaveSettingsRequest;
use App\Models\Order;
use App\Models\Region;
use App\Models\Tariff;
use App\Services\CourierServices\CourierServiceService;
use App\Services\Google\MapsService;
use App\Services\Options\OptionService;

class PriceService
{
    public function __construct(
        private MapsService $mapsService,
        private OptionService $optionService,
        private CourierServiceService $courierServiceService,
    )
    {
        
    }

    public function calcForRoute(array $data): int
    {
        $tariffPrice = $this->calcTariffPrice($data);
        $additionalPrice = $this->calcAdditionalPrice($data);

        return $tariffPrice + $additionalPrice;
    }

    private function calcTariffPrice(array $data): float
    {
        $insideRegions = $this->insideRegions($data['route']);
        $kms = $this->mapsService->distanceInKm($data['route']);
        
        $prices = array_map(fn ($region) => $region->tariff->calcPrice($kms), $insideRegions);

        if ($this->outsideRegions($data['route'])) {
            $prices[] = Tariff::getDefault()->calcPrice($kms);
        }

        return max($prices);
    }

    private function outsideRegions(array $route): bool
    {
        foreach ($route as $point) {
            $inside = false;
            foreach (Region::all() as $region) {
                $bool = $region->isPointInside(
                    $point['lat'], 
                    $point['lng']
                );
                
                if ($bool) {
                    $inside = true;
                }
            }

            if (! $inside) {
                return true;
            }
        }

        return false;
    }

    private function insideRegions(array $route): array
    {
        $insideRegions = [];
        foreach (Region::all() as $region) {
            foreach ($route as $point) {
                $inside = $region->isPointInside(
                    $point['lat'], 
                    $point['lng']
                );

                if ($inside) {
                    $insideRegions[] = $region;
                    break;
                }
            }
        }

        return $insideRegions;
    }

    private function calcAdditionalPrice(array $data): float
    {
        $settings = $this->getSettings();

        $price = 0;
        $price += $settings['call'];

        $stopsCount = count($data['route']) - 2;
        $price += $settings['stop'] * $stopsCount;

        if ($data['service'] == Order::SHIPPING) {
            foreach ($this->courierServiceService->all() as $item) {
                if ($item->name == $data['courier_service'] ?? '') {
                    $price += $item->price;
                    break;
                }
            }
        }

        return $price;
    }

    public function getSettings(): array
    {
        $settings = json_decode($this->optionService->get('price_settings'), true) ?? [];

        return [
            'call' => $settings['call'] ?? 0,
            'stop' => $settings['stop'] ?? 0,
        ];
    }

    public function saveSettings(SaveSettingsRequest $request): void
    {
        $this->optionService->save('price_settings', json_encode($request->validated()));
    }
}