<?php

namespace App\Services\Price;

use App\Http\Requests\Price\SaveSettingsRequest;
use App\Interfaces\ICalcDistance;
use App\Models\Order;
use App\Models\Region;
use App\Models\Tariff;
use App\Services\CourierServices\CourierServiceService;
use App\Services\Options\OptionService;

class PriceService
{
    public const ZOLOCHIV_LATLNG = [
        'lat' => 49.8094,
        'lng' => 24.9014,
    ];

    public function __construct(
        private ICalcDistance $calcDistance,
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
        $kms = $this->calcDistance->distanceInKm($data['route']);
        
        $prices = array_map(fn ($region) => $region->tariff->calcPrice($kms), $insideRegions);

        if ($this->outsideRegions($data['route'])) {
            $prices[] = Tariff::getDefault()->calcPrice($kms);
        }

        $price = max($prices);

        if ($this->isInsideZolochiv($data['route']) and $kms > 10) {
            $price *= 0.75;
        }

        return $price;
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

        if ($this->isOutsideZolochiv($data['route'])) {
            $price += $settings['outside_zolochiv'] * $this->getDistanceInKm(
                self::ZOLOCHIV_LATLNG, 
                $data['route'][count($data['route'])-1]
            );
        }

        return $price;
    }

    private function isOutsideZolochiv(array $route, float $radius = 3): bool
    {
        $start = $route[0];
        $end = $route[count($route)-1];
        
        if (
            $this->getDistanceInKm($start, self::ZOLOCHIV_LATLNG) > $radius and
            $this->getDistanceInKm($end, self::ZOLOCHIV_LATLNG) > $radius
        ) {
            return true;
        }

        return false;
    }

    private function isInsideZolochiv(array $route, float $radius = 3): bool
    {
        $start = $route[0];
        $end = $route[count($route)-1];

        if (
            $this->getDistanceInKm($start, self::ZOLOCHIV_LATLNG) <= $radius and
            $this->getDistanceInKm($end, self::ZOLOCHIV_LATLNG) <= $radius
        ) {
            return true;
        }

        return false;
    }

    public function getDistanceInKm($point1 , $point2): float
    {
        $earthRadius = 6371;
        $point1Lat = $point1['lat'];
        $point2Lat =$point2['lat'];
        $deltaLat = deg2rad($point2Lat - $point1Lat);
        $point1Long =$point1['lng'];
        $point2Long =$point2['lng'];
        $deltaLong = deg2rad($point2Long - $point1Long);
        $a = sin($deltaLat/2) * sin($deltaLat/2) + cos(deg2rad($point1Lat)) * cos(deg2rad($point2Lat)) * sin($deltaLong/2) * sin($deltaLong/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
    
        $distance = $earthRadius * $c;

        return $distance;
    }

    public function getSettings(): array
    {
        $settings = json_decode($this->optionService->get('price_settings'), true) ?? [];

        return [
            'call' => $settings['call'] ?? 0,
            'stop' => $settings['stop'] ?? 0,
            'outside_zolochiv' => $settings['outside_zolochiv'] ?? 0,
        ];
    }

    public function saveSettings(SaveSettingsRequest $request): void
    {
        $this->optionService->save('price_settings', json_encode($request->validated()));
    }
}