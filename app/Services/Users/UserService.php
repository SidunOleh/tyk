<?php

namespace App\Services\Users;

use App\Models\User;
use App\Services\Service;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class UserService extends Service
{
    protected string $model = User::class;

    public function update(Model $model, array $data): void
    {
        $password = $data['password'] ?? null;

        if ($password) {
            $model->update(['password' => $password,]);
        }

        unset($data['password']);

        $model->update($data);
    }

    public function changePassword(User $user, string $password): void
    {
        $user->update(['password' => $password,]);
    }

    public function index(Request $request): LengthAwarePaginator
    {
        $page = $request->query('page', 1);
        $perpage = $request->query('perpage', 15);
        $orderby = $request->query('orderby', 'created_at');
        $order = $request->query('order', 'DESC');
        $s = $request->query('s', '');
        $roles = $request->query('role', []);

        $models = $this->model::orderBy($orderby, $order)
            ->search($s)
            ->roles($roles)
            ->paginate($perpage, ['*'], 'page', $page);

        return $models;
    }

    public function getDispatchers(): Collection
    {
        return User::roles(['диспетчер'])->get();
    }
}