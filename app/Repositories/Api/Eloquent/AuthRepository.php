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
}