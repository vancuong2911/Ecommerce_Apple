<?php

namespace App\Repositories\Users;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Repositories\Users\UsersRepositoryInterface;
use App\Repositories\BaseRepository;

class UsersRepository extends BaseRepository implements UsersRepositoryInterface
{
    public function getModel()
    {
        return User::class;
    }
    public function getUserCount($type)
    {
        $user =  $this->model->get();
        if ($type !== null) {
            $user = $user->where('usertype', $type);
        }
        return $user->count();
    }
}
