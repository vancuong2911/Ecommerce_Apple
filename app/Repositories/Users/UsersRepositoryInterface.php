<?php

namespace App\Repositories\Users;

use App\Repositories\RepositoryInterface;

interface UsersRepositoryInterface extends RepositoryInterface
{
    public function getUserCount($type);
}
