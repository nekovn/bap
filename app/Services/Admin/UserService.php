<?php

namespace App\Services\Admin;

use App\Repositories\Admin\UserRepository;
use App\Services\BaseServiceTrait;

class UserService
{
    use BaseServiceTrait {
        BaseServiceTrait::find as findItem;
        BaseServiceTrait::findByPkey as findByPkeyItem;
        BaseServiceTrait::delete as deleteItem;
        BaseServiceTrait::search as searchItem;
        BaseServiceTrait::getLastRow as getLastRowDate;
    }
    public $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }


}
