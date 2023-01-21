<?php

namespace App\Http\Controllers\Admin;

use App\Enums\DefaultDefine;
use App\Http\Controllers\Admin\Crud\CrudController;
use App\Http\Controllers\Admin\Facades\ListContainer;
use App\Http\Requests\Admin\FilterRequest;
use App\Services\Admin\LogService;
use App\Http\Controllers\BaseControllerTrait;
use Illuminate\Http\JsonResponse as JsonResponse;

class ShowLogController extends CrudController
{
    use BaseControllerTrait {
        BaseControllerTrait::index as indexTrait;
    }

    protected $screen = 'Admin/ShowLog';
    protected $router = 'admin.log';
    protected $routerIndex = 'admin.log.index';
    protected $searchBy = ['file_line', 'message_code', 'screen'];
    protected $isActions = ['create' => false, 'delete' => true];
    protected $showPage = DefaultDefine::PER_PAGE_LIST;
    protected $defaultPerPage = DefaultDefine::PER_PAGE;
    protected $defaultSort = DefaultDefine::SORT_DESC;
    protected $service;
    protected $data = [];
    protected $thead = [];
    protected $filter = '';
    protected $container = [];

    public function __construct(LogService $logService)
    {
        $this->service = $logService;
        $this->service->repository->screen = $this->screen;
        $this->thead = config('admin.page.page-setting.thead.log');
        $this->filter = config('admin.page.page-setting.filter.log');
        $this->container = ListContainer::instance();
    }

    public function delete(FilterRequest $validation): JsonResponse
    {
        //レスポンスデータ
        $response = $this->handleProcessSuccess($validation, 'crudDelete');
        return response()->json($response);
    }
}
