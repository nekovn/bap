<?php

namespace App\Http\Controllers\Admin\Crud;

use App\Enums\DefaultDefine;
use App\Helpers\SystemHelper;
use App\Http\Controllers\Admin\Filter\FilterController;
use App\Models\Member;

class CrudController extends FilterController implements CrudInterface
{
    use CrudTrait;

    public function crudCreate($conditions, $validatedData, $requestData): array
    {
        //現在日付は最新の作成日付以上の時、新規作成する。逆にエラーメッセージを返す
        $column = 'created_at';
        if (!$this->isContinuous($column)) {
            //最新データを取得する
            $newData = $this->removeCacheAndReturnResult($conditions, $requestData);
            //レスポンスError
            return SystemHelper::response(DefaultDefine::STATUS_NO_CONTENT, __('messages.errors_modifier'), $newData);
        } else {
            //作成実行
            $result = $this->service->create($validatedData);
            //レスポンスデータ
            return $this->setResponse($result, $validatedData, __('messages.success_create'), $conditions, $requestData);
        }
    }

    public function crudEdit($conditions, $validatedData, $requestData): array
    {
        //現在日付は最新の作成日付以上の時、新規作成する。逆にエラーメッセージを返す
        $column = 'updated_at';
        if (!$this->isContinuous($column)) {
            //クライアントにレスポンスErrorを返す
            return SystemHelper::response(DefaultDefine::STATUS_NO_CONTENT, __('messages.errors_modifier'));
        } else if (!$this->isExclusiveUpdate($validatedData['id'], $validatedData['updated_at'])) {
            //最新データを返す (排他更新チェック)
            $newData = $this->removeCacheAndReturnResult($conditions, $requestData);
            //クライアントにレスポンスErrorを返す
            return SystemHelper::response(DefaultDefine::STATUS_NO_CONTENT, __('messages.data_been_changed'), $newData);
        } else {
            //更新実行
            $result = $this->service->update($validatedData, $validatedData['id']);
            //クライアントにレスポンスデータを返す
            return $this->setResponse($result, $validatedData, __('messages.success_edit'), $conditions, $requestData);
        }
    }

    public function crudDelete($conditions, $validatedData, $requestData): array
    {
        //削除ID
        $deleteId = $validatedData['deleteId'];
        $isExclusiveDelete = $this->isExclusiveDelete($deleteId);
        //排他削除チェック
        if (!$isExclusiveDelete) {
            //最新データを返す
            $newData = $this->removeCacheAndReturnResult($conditions, $requestData);
            //クライアントにレスポンスErrorを返す
            return SystemHelper::response(DefaultDefine::STATUS_NO_CONTENT, __('messages.data_been_deleted'), $newData);
        } else {
            //削除実行
            $result = $this->service->deleteItem(['id' => $deleteId]);

            //トータル取得
            $count = ['count' => count($deleteId)];
            //クライアントにレスポンスデータを返す
            return $this->setResponse($result, $validatedData, __('messages.success_delete', $count), $conditions, $requestData);
        }
    }

}
