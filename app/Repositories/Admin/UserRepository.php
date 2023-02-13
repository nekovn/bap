<?php

namespace App\Repositories\Admin;

use App\Models\User;
use App\Repositories\BaseRepositoryTrait;

class UserRepository
{
    use BaseRepositoryTrait;
    public $screen = '';

    public function setModel()
    {
        return new User();
    }

    public function getModel()
    {
        return $this->setModel()::where([])->with('gender', 'isBlock', 'isDelete');
    }


}
