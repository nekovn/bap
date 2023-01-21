<?php

namespace App\Services\Admin;

use App\Repositories\Admin\LogRepository;
use App\Services\BaseServiceTrait;

class LogService
{
    use BaseServiceTrait {
        BaseServiceTrait::find as findItem;
        BaseServiceTrait::delete as deleteItem;
        BaseServiceTrait::search as searchItem;
    }
    public $repository;

    public function __construct(LogRepository $repository)
    {
        $this->repository = $repository;
    }

}
