<?php

namespace App\Services\Admin;

use App\Repositories\Admin\RoomRepository;
use App\Services\BaseServiceTrait;

class RoomService
{
    use BaseServiceTrait {
        BaseServiceTrait::find as findItem;
        BaseServiceTrait::findByPkey as findByPkeyItem;
        BaseServiceTrait::delete as deleteItem;
        BaseServiceTrait::search as searchItem;
        BaseServiceTrait::getLastRow as getLastRowDate;
    }
    public $repository;

    public function __construct(RoomRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getListRoom()
    {
       return $this->repository->setModel()::ListRoom();
    }

}
