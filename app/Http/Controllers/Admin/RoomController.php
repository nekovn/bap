<?php

namespace App\Http\Controllers\Admin;

use App\Enums\DefaultDefine;
use App\Helpers\SystemHelper;
use App\Http\Controllers\Admin\Crud\CrudController;
use App\Http\Controllers\Admin\Facades\DefineFacade;
use App\Http\Controllers\Admin\Facades\ListContainer;
use App\Http\Controllers\BaseControllerTrait;
use App\Http\Requests\Admin\FilterRequest;
use App\Http\Requests\Admin\RoomRequest;
use App\Services\Admin\RoomService;
use Illuminate\Http\JsonResponse as JsonResponse;

class RoomController extends CrudController
{
    use BaseControllerTrait;

    protected $screen = 'Admin/Room';
    protected $router = 'admin.room';
    protected $routerIndex = 'admin.room.index';
    protected $searchBy = ['room_number', 'title', 'address', 'price'];
    protected $isActions = ['create' => true, 'delete' => true];
    protected $showPage = DefaultDefine::PER_PAGE_LIST;
    protected $defaultPerPage = DefaultDefine::PER_PAGE;
    protected $defaultSort = DefaultDefine::SORT_ASC;
    protected $defineName = 'define-room';
    protected $service;
    protected $container;
    protected $define;
    protected $data = [];
    protected $thead = [];
    protected $filter = '';

    public function __construct(RoomService $roomService)
    {
        $this->service = $roomService;
        $this->service->repository->screen = $this->screen;
        $this->thead = config('admin.page.page-setting.thead.room');
        $this->filter = config('admin.page.page-setting.filter.room');
        $this->container = ListContainer::instance();
        $this->define = DefineFacade::instance();
        $this->data['formInput'] = SystemHelper::encrypt(json_encode($this->getDefineData()), config('app.secret'));
    }

    public function create(RoomRequest $validation): JsonResponse
    {
        //レスポンスデータ
        $response = $this->handleProcessSuccess($validation, 'crudCreate');
        return response()->json($response);
    }

    public function edit(RoomRequest $validation): JsonResponse
    {
        //レスポンスデータ
        $response = $this->handleProcessSuccess($validation, 'crudEdit');
        return response()->json($response);
    }

    public function delete(FilterRequest $validation): JsonResponse
    {
        //レスポンスデータ
        $response = $this->handleProcessSuccess($validation, 'crudDelete');
        return response()->json($response);
    }

}
