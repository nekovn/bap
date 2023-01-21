<?php

namespace App\Repositories\Admin;

use App\Models\Member;
use App\Repositories\BaseRepositoryTrait;

class MemberRepository
{
    use BaseRepositoryTrait;
    public $screen = '';

    public function setModel()
    {
        return new Member();
    }

    public function getModel()
    {
        return $this->setModel()::where([])->with('customerType', 'gender', 'isBlock', 'isDelete', 'roomDistrict');
    }


}
