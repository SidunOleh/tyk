<?php

namespace App\Services\Clients;

use App\DTO\Clients\UpdatePersonalInfoDTO;
use App\Http\Requests\Admin\Clients\FindOrCreateRequest;
use App\Models\Client;
use App\Models\Order;
use App\Services\Service;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            ->with('ordersByDate.orderItems')
            ->with('ordersByDate.client')
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

    public function updatePersonalInfo(Client $client, UpdatePersonalInfoDTO $dto): void
    {
        $client->update(['full_name' => $dto->fullName, 'phone' => $dto->phone,]);
    }

    public function addAddress(Client $client, string $address): void
    {        
        $newAddress = $this->getLatLng($address);
        $newAddress['address'] = $address;

        $client->addAddresses([$newAddress]);
    }

    public function deleteAddress(Client $client, string $address): void
    {
        $addresses = $client->addresses;

        foreach ($addresses as $i => $addressItem) {
            if ($addressItem['address'] == $address) {
                unset($addresses[$i]);
                break;
            }
        }

        $client->update(['addresses' => $addresses]);
    }

    public function getOrders(Client $client): Collection
    {
        return Order::where('client_id', $client->id)
            ->with('orderItems')
            ->with('orderItems.product')
            ->with('orderItems.product.categories')
            ->with('client')
            ->with('courier')
            ->with('zakladAddonAmounts')
            ->get();
    }

    public function delete(Model $model): void
    {
        if ($model->phone == '(090) 000-00-00') {
            DB::table('clients')->where('id', $model->id)->delete();
        } else {
            $model->delete();
        }
    }
}