<?php

namespace App\Http\Controllers\Admin\Crud;

interface CrudInterface
{
    /**
     * データを作成する
     * @param $conditions //条件
     * @param $validatedData //validatedデータ
     * @param $requestData //リクエストデータ
     * @return array
     */
    public function crudCreate($conditions, $validatedData, $requestData): array;

    /**
     * データを更新する
     * @param $conditions //条件
     * @param $validatedData //validatedデータ
     * @param $requestData //リクエストデータ
     * @return array
     */
    public function crudEdit($conditions, $validatedData, $requestData): array;

    /**
     * データを削除する
     * @param $conditions //条件
     * @param $validatedData //validatedデータ
     * @param $requestData //リクエストデータ
     * @return array
     */
    public function crudDelete($conditions, $validatedData, $requestData): array;
}
