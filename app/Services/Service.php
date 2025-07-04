<?php

namespace App\Services;

use App\Exceptions\NotFoundAddressException;
use App\Services\Google\MapsService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Service
{
    protected string $model;

    public function create(array $data): Model
    {
        $model = $this->model::create($data);

        return $model;
    }

    public function update(Model $model, array $data): void
    {
        $model->update($data);
    }

    public function delete(Model $model): void
    {
        $model->delete();
    }

    public function bulkDelete(array $ids): void
    {
        $this->model::destroy($ids);
    }

    public function index(Request $request): LengthAwarePaginator
    {
        $page = $request->query('page', 1);
        $perpage = $request->query('perpage', 15);
        $orderby = $request->query('orderby', 'created_at');
        $order = $request->query('order', 'DESC');
        $s = $request->query('s', '');

        $models = $this->model::orderBy($orderby, $order)
            ->search($s)
            ->paginate($perpage, ['*'], 'page', $page);

        return $models;
    }

    public function search(string $s): Collection
    {        
        if ($s) {
            $models = $this->model::search($s)->get();
        } else {
            $models = new Collection;
        }

        return $models;
    }

    public function all(): Collection
    {
        return $this->model::all();
    }

    protected function getLatLng(string $address): array
    {
        $response = (new MapsService)->geocoding($address);

        if (! $response) {
            new NotFoundAddressException($address);
        }

        $result = $response[0];

        $latLng['lat'] = $result['geometry']['location']['lat'];
        $latLng['lng'] = $result['geometry']['location']['lng'];

        return $latLng;
    }
}