<?php

namespace App\Services\Google;

use App\Interfaces\ICalcDistance;
use Exception;
use Illuminate\Support\Facades\Http;

class MapsService implements ICalcDistance
{
    private string $key;

    private string $baseUrl;

    public function __construct()
    {
        $this->key = config('services.google_maps_key');
        $this->baseUrl = 'https://maps.googleapis.com/maps/api';
    }

    public function geocoding(string $address): array
    {
        $data = $this->makeRequest('geocode', [
            'address' => $address,
        ]);

        return $data['results'];
    }

    public function distanceInKm(array $route): float
    {
        $origin = $route[0];
        $origin = "{$origin['lat']},{$origin['lng']}";
        $destination = $route[count($route)-1];
        $destination = "{$destination['lat']},{$destination['lng']}";

        unset($route[count($route)-1]);
        unset($route[0]);
        $waypoints = implode('|', array_map(fn ($point) => "{$point['lat']},{$point['lng']}", $route));

        $data = $this->makeRequest('directions', [
            'origin' => $origin,
            'waypoints' => $waypoints,
            'destination' => $destination,
            'travelMode' => 'DRIVING',
        ]);

        $meters = 0;
        foreach ($data['routes'][0]['legs'] as $leg) {
            $meters += $leg['distance']['value'];
        } 

        $kms = $meters / 1000;

        return $kms;
    }

    private function makeRequest(string $service, array $data): array
    {
        $response = Http::get("{$this->baseUrl}/{$service}/json", [
            'key' => $this->key,
            ...$data
        ]);

        $data = $response->json();

        if ($data['status'] != 'OK') {
            throw new Exception($data['error_message'] ?? $data['status']);
        }

        return $data;
    }
}