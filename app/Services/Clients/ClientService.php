<?php

namespace App\Services\Clients;

use App\Http\Requests\Admin\Clients\FindOrCreateRequest;
use App\Http\Requests\Clients\AddAddressRequest;
use App\Http\Requests\Clients\DeleteAddressRequest;
use App\Http\Requests\Clients\UpdatePersonalInfoRequest;
use App\Models\Client;
use App\Services\Service;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ClientService extends Service
{
    protected string $model = Client::class;

    public function index(Request $request): LengthAwarePaginator
    {
        $page = $request->query('page', 1);
        $perpage = $request->query('perpage', 15);
        $orderby = $request->query('orderby', 'created_at');
        $order = $request->query('order', 'DESC');
        $s = $request->query('s', '');

        $models = Client::with('ordersByDate')
            ->with('ordersByDate.courier')
            ->orderBy($orderby, $order)
            ->search($s)
            ->paginate($perpage, ['*'], 'page', $page);

        return $models;
    }

    public function findOrCreate(FindOrCreateRequest $request): Client
    {
        return Client::firstOrCreate(['phone' => $request->phone], ['full_name' => $request->full_name ?? 'Новий клієнт']);
    }

    public function updatePersonalInfo(Client $client, UpdatePersonalInfoRequest $request): void
    {
        $client->update($request->validated());
    }

    public function addAddress(Client $client, AddAddressRequest $request): void
    {        
        $address = $this->getLatLng($request->address);
        $address['address'] = $request->address;

        $client->addAddresses([$address]);
    }

    public function deleteAddress(Client $client, DeleteAddressRequest $request): void
    {
        $addresses = $client->addresses;

        unset($addresses[$request->index]);

        $client->update(['addresses' => $addresses]);
    }

    public function getOrders(Client $client): Collection
    {
        return $client->ordersByDate;
    }
}