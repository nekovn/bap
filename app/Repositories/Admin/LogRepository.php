<?php

namespace App\Repositories\Admin;

use App\Models\LogInfo;
use App\Repositories\BaseRepositoryTrait;

class LogRepository
{
    use BaseRepositoryTrait;

    public $screen = '';

    public function setModel()
    {
        return new LogInfo();
    }

    public function getModel()
    {
        return $this->setModel()::where([]);
    }
}
