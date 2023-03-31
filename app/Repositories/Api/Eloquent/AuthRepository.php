<?php 

namespace App\Repositories\Api\Eloquent;

use App\Models\User;
use App\Repositories\Api\BaseRepository;
use App\Repositories\Api\Interfaces\AuthRepositoryInterface;

class AuthRepository extends BaseRepository implements AuthRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function allUser()
    {
        $users = $this->connection()->paginate(2);
        return $users;
    }

    public function createUser(array $params)
    {
        return $this->create($params);
    }

    public function updateUser($id,array $params)
    {
        return $this->update($id, $params);
    }

    public function deleteUser()
    {
        $id = auth()->user()->id;

        if($id){
            deleteImage(auth()->user()->image);
        }
        
        return $this->delete($id);
    }
}