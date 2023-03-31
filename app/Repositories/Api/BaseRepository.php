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

        if(!$query){
            throw new QueryException("Id Not Found!");
        }

        return $query;
    }

    public function create(array $params)
    {
        $query = $this->connection()->create($params);

        if(!$query){
            throw new QueryException("Creating Failed!");
        }

        return $query;
    }

    public function update($id, array $params)
    {
        $query = $this->connection()->where('id', $id)->update($params);

        if(!$query){
            throw new QueryException("Updating Failed!");
        }

        return $query;
    }

    public function delete($id)
    {
        $query = $this->connection()->destroy($id);
        
        if (!$query) {
            throw new QueryException("Deleting Failed!");
        }

        return $query;
    }
}