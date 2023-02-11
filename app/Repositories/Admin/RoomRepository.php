<?php

namespace App\Repositories\Admin;

use App\Models\Room;
use App\Repositories\BaseRepositoryTrait;

class RoomRepository
{
    use BaseRepositoryTrait;
    public $screen = '';

    public function setModel()
    {
        return new Room();
    }

    public function getModel()
    {
        return $this->setModel()::where([])
            ->with('districtId', 'hotId', 'existId', 'statusId', 'utility_room', 'space_room', 'space_share', 'image');
    }


}
