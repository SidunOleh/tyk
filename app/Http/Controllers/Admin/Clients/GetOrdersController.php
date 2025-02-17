<?php

namespace App\Http\Controllers\Admin\Clients;

use App\Http\Controllers\Controller;
use App\Http\Resources\Order\OrdersSearchCollection;
use App\Models\Client;
use App\Services\Clients\ClientService;

class GetOrdersController extends Controller
{
    public function __construct(
        public ClientService $clientService
    )
    {
        
    }

    public function __invoke(Client $client)
    {
        $orders = $this->clientService->getOrders($client);

        return response(['orders' => new OrdersSearchCollection($orders)]);
    }
}
