<?php

namespace App\Services;

use App\Exceptions\NotFoundAddressException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use GoogleMaps;

class Service
{
    protected string $model;

    public function create(FormRequest $request): Model
    {
        $model = $this->model::create($request->validated());

        return $model;
    }

    public function update(Model $model, FormRequest $request): void
    {
        $model->update($request->validated());
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

    protected function getLatLng(string $address): array
    {
        $response = GoogleMaps::load('geocoding')
            ->setParamByKey('address', $address)
            ->get();
        $response = json_decode($response, true);

        if (! $response['results']) {
            new NotFoundAddressException($address);
        }

        $result = $response['results'][0];

        $latLng['lat'] = $result['geometry']['location']['lat'];
        $latLng['lng'] = $result['geometry']['location']['lng'];

        return $latLng;
    }
}