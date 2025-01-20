<?php

namespace App\Services\Clients;

use App\Http\Requests\Clients\AddAddressRequest;
use App\Http\Requests\Clients\DeleteAddressRequest;
use App\Http\Requests\Clients\UpdatePersonalInfoRequest;
use App\Models\Client;
use App\Services\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

class ClientService extends Service
{
    protected string $model = Client::class;

    public function create(FormRequest $request): Model
    {
        $validated = $request->validated();
        $addresses = [];
        foreach ($validated['addresses'] as $address) {
            $addresses[] = array_merge(['address' => $address], $this->getLatLng($address));
        }
        $validated['addresses'] = $addresses;

        $client = Client::create($validated);

        return $client;
    }

    public function update(Model $client, FormRequest $request): void
    {
        $validated = $request->validated();
        $addresses = [];
        foreach ($validated['addresses'] as $address) {
            $addresses[] = array_merge(['address' => $address], $this->getLatLng($address));
        }
        $validated['addresses'] = $addresses;

        $client->update($validated);
    }

    public function updatePersonalInfo(Client $client, UpdatePersonalInfoRequest $request): void
    {
        $client->update($request->validated());
    }

    public function addAddress(Client $client, AddAddressRequest $request): void
    {        
        $address = $this->getLatLng($request->address);
        $address['address'] = $request->address;

        $client->update(['addresses' => [...$client->addresses ?? [], $address]]);
    }

    public function deleteAddress(Client $client, DeleteAddressRequest $request): void
    {
        $addresses = $client->addresses;

        unset($addresses[$request->index]);

        $client->update(['addresses' => $addresses]);
    }
}