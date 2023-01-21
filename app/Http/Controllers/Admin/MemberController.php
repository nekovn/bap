<?php

namespace App\Http\Controllers\Admin;

use App\Enums\DefaultDefine;
use App\Helpers\SystemHelper;
use App\Http\Controllers\Admin\Crud\CrudController;
use App\Http\Controllers\Admin\Facades\DefineFacade;
use App\Http\Controllers\Admin\Facades\ListContainer;
use App\Http\Controllers\BaseControllerTrait;
use App\Http\Requests\Admin\FilterRequest;
use App\Http\Requests\Admin\MemberRequest;
use App\Services\Admin\MemberService;
use Illuminate\Http\JsonResponse as JsonResponse;

class MemberController extends CrudController
{
    use BaseControllerTrait;

    protected $screen = 'Admin/Member';
    protected $router = 'admin.member';
    protected $routerIndex = 'admin.member.index';
    protected $searchBy = ['full_name', 'phone', 'email', 'room_number'];
    protected $isActions = ['create' => true, 'delete' => true];
    protected $showPage = DefaultDefine::PER_PAGE_LIST;
    protected $defaultPerPage = DefaultDefine::PER_PAGE;
    protected $defaultSort = DefaultDefine::SORT_ASC;
    protected $defineName = 'define-member';
    protected $service;
    protected $container;
    protected $define;
    protected $data = [];
    protected $thead = [];
    protected $filter = '';

    public function __construct(MemberService $logService)
    {
        $this->service = $logService;
        $this->service->repository->screen = $this->screen;
        $this->thead = config('admin.page.page-setting.thead.member');
        $this->filter = config('admin.page.page-setting.filter.member');
        $this->container = ListContainer::instance();
        $this->define = DefineFacade::instance();
        $this->data['room'] = SystemHelper::encrypt(json_encode($this->getListRoom()), config('app.secret'));
        $this->data['formInput'] = SystemHelper::encrypt(json_encode($this->getDefineData()), config('app.secret'));
    }

    public function create(MemberRequest $validation): JsonResponse
    {
        //レスポンスデータ
        $response = $this->handleProcessSuccess($validation, 'crudCreate');
        return response()->json($response);
    }

    public function edit(MemberRequest $validation): JsonResponse
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
