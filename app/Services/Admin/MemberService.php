<?php

namespace App\Services\Admin;

use App\Repositories\Admin\MemberRepository;
use App\Services\BaseServiceTrait;

class MemberService
{
    use BaseServiceTrait {
        BaseServiceTrait::find as findItem;
        BaseServiceTrait::findByPkey as findByPkeyItem;
        BaseServiceTrait::delete as deleteItem;
        BaseServiceTrait::search as searchItem;
        BaseServiceTrait::getLastRow as getLastRowDate;
    }
    public $repository;

    public function __construct(MemberRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getListRoom()
    {
       return $this->repository->setModel()::ListRoom();
    }

}
