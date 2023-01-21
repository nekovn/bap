<?php

namespace App\Http\Controllers\Admin\Filter;


use App\Http\Requests\Admin\FilterRequest;
use Illuminate\Http\JsonResponse;

interface FilterInterface
{
    /**
     * データをフィルターする
     * @param FilterRequest $validation
     * @return JsonResponse
     */
    function filter(FilterRequest $validation):JsonResponse;

    /**
     * 自由検索
     * @param FilterRequest $validation
     * @return JsonResponse
     */
    function search(FilterRequest $validation):JsonResponse;
}
