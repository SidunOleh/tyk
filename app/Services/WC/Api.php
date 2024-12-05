<?php

namespace App\Services\WC;

use Automattic\WooCommerce\Client;

class Api
{
    public function __construct(
        private Client $client
    )
    {
        
    }

    public function products(array $params = []): array
    {
        $data = $this->client->get('products', $params);

        $data['data'] = $data;
        $data['meta']['current_page'] = 
            $params['page'] ?? 1;
        $data['meta']['per_page'] = 
            $params['per_page'] ?? 10;
        
        $headers = $this->client->http->getResponse()->getHeaders();

        $data['meta']['total'] = $headers['x-wp-total'];

        return $data;
    }
}