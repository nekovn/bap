<?php

namespace App\Http\Controllers\Admin\Filter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FilterRequest;
use Illuminate\Http\JsonResponse;

class FilterController extends Controller implements FilterInterface
{
    use FilterTrait;

    public function filter(FilterRequest $validation): JsonResponse
    {
        //レスポンスデータ
        $response = $this->handleProcessFilter($validation);
        //クライアントにレスポンスデータを返す
        return response()->json($response);
    }

    public function search(FilterRequest $validation): JsonResponse
    {
        //レスポンスデータ
        $response = $this->handleProcessFilter($validation, 'search');
        //クライアントにレスポンスデータを返す
        return response()->json($response);
    }

}
