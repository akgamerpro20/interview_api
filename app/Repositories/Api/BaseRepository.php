<?php

namespace App\Repositories\Api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use App\Repositories\Api\BaseRepositoryInterface;

class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function connection()
    {
        return $this->model;
    }

    public function find($id)
    {
        $query = $this->connection()->find($id);

        return $query;
    }

    public function create(array $params)
    {
        $query = $this->connection()->create($params);

        return $query;
    }

    public function update($id, array $params)
    {
        $query = $this->connection()->where('id', $id)->update($params);

        return $query;
    }

    public function delete($id)
    {
        $query = $this->connection()->destroy($id);

        return $query;
    }
}