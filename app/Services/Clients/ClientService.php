<?php

namespace App\Services\Clients;

use App\Http\Requests\Admin\Clients\FindOrCreateRequest;
use App\Http\Requests\Clients\AddAddressRequest;
use App\Http\Requests\Clients\DeleteAddressRequest;
use App\Http\Requests\Clients\UpdatePersonalInfoRequest;
use App\Models\Client;
use App\Services\Service;

class ClientService extends Service
{
    protected string $model = Client::class;

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
}