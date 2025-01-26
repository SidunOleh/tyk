<?php

namespace App\Services\Mapon;

use Exception;
use Illuminate\Support\Facades\Http;

class MaponService
{
    private string $key;

    private $client;

    public function __construct()
    {
        $this->key = config('services.mapon_api_key');
        $this->client = Http::baseUrl('https://mapon.com/api/v1')->withOptions(['query' => ['key' => $this->key]]);
    }

    public function getUnitList()
    {
        $result = $this->client->get('/unit/list.json')->json();

        if (isset($result['error'])) {
            throw new Exception($result['error']['msg'], $result['error']['code']);
        }

        return $result;
    }
}