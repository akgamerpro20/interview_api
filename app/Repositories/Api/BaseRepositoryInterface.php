<?php

namespace App\Repositories\Api;

interface BaseRepositoryInterface
{
    //For Get Model
    public function connection();

    //Find data with Id
    public function find($id);

    //Create data
    public function create(array $params);

    //Update data
    public function update($id, array $params);

    // Delete data
    public function delete($id);
}