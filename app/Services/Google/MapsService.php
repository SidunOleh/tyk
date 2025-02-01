<?php

namespace App\Services\Google;

use Exception;
use Illuminate\Support\Facades\Http;

class MapsService
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
        $response = Http::get("{$this->baseUrl}/geocode/json", [
            'key' => $this->key,
            'address' => $address,
        ]);
        
        $data = $response->json();

        if ($data['status'] != 'OK') {
            throw new Exception($data['error_message'] ?? $data['status']);
        }

        return $data['results'];
    }
}