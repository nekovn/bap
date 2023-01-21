<?php

namespace App\Http\Controllers\Admin\Crud;

use App\Enums\DefaultDefine;
use App\Helpers\SystemHelper;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait CrudTrait
{
    /**
     * 連続処理かどうか判断する
     * @param $column //created_at || updated_at
     * @return bool
     */
    protected function isContinuous($column): bool
    {
        //連続登録禁止
        $nowDate = new Carbon('now');
        //現在日付ー180秒 -> 3分前
        $nowDate->subSecond(DefaultDefine::CREATE_SECOND);
        //DBから現在の作成日付取得
        $updateDate = $this->service->getLastRowDate($column);
        if (is_null($updateDate)) {
            return true;
        } else {
            //現在日付は最新の作成日付以上の時
            $oldData = new Carbon($updateDate);
            return $nowDate->gte($oldData);
        }
    }

    /**
     * 部屋の既存を設定する
     * @param $room_number
     * @param $district_id
     * @return void
     */
    protected function setExitsRoom($room_number, $district_id)
    {
        DB::beginTransaction();
        try {
            DB::commit();
            return Room::SetExistsRoom($room_number, $district_id);
        } catch (\Exception $exception) {
            DB::rollBack();
            SystemHelper::log(['message' => $exception->getMessage(), 'code' => "room:{$room_number}_district:{$district_id}"], __METHOD__, __LINE__, $this->screen);
            abort(500);
        }
    }

    /**
     * レスポンスのデータ設定
     * @param $result
     * @param array $data validatedデータ
     * @param string $message メッセージ
     * @param array $conditions 条件
     * @param array $requestData 条件
     * @return array
     */
    protected function setResponse($result, array $data, string $message, array $conditions, array $requestData): array
    {
        //正常の時
        if ($result) {
            //列の値オプションを設定
            $this->setValueOptionsForColumn($data);
            //最新データを取得する
            $newData = $this->removeCacheAndReturnResult($conditions, $requestData);
            //レスポンスデータ
            $response = SystemHelper::response(DefaultDefine::STATUS_SUCCESS, $message, $newData);
        } else {
            $response = SystemHelper::response(DefaultDefine::STATUS_SERVER_ERROR, __('messages.errors_system'));
        }

        return $response;
    }

    /**
     * 列の値オプションを設定
     * @param $data
     * @return void
     */
    protected function setValueOptionsForColumn($data)
    {
        //部屋の既存を設定する
        if (isset($data['room_number']) && isset($data['room_district'])) {
            $this->setExitsRoom($data['room_number'], $data['room_district']);
        }
    }

    /**
     * キャッシュ削除して、最新のコンテナ取得
     * @param array $conditions
     * @param array $requestData
     * @return array
     */
    protected function removeCacheAndReturnResult(array $conditions, array $requestData): array
    {
        //データリストのキャッシュ削除
        $this->container->destroy($this->screen);
        //Roomリストのキャッシュ削除
        $this->container->destroy(DefaultDefine::CACHE_ROOM);
        //結果
        $findItem = $this->service->findItem($conditions);
        //項目トータル
        $count = $this->service->repository->getModel()->count();
        //1ページあたり
        $per_page = $requestData['per_page'];
        //現在ページ
        $current_page = $requestData['offset'];
        //フィルターの結果を取得する
        $result = $this->getResultFilterData($per_page, $current_page, $findItem, $count, $conditions);
        return SystemHelper::encrypt(json_encode($result), config('app.secret'));
    }

    /**
     * 排他更新チェック
     * @param $oldUuid
     * @param $id
     * @return bool
     */
    protected function isExclusiveUpdate($id, $oldUuid): bool
    {
        //条件を設定する
        $where = [['id', $id]];
        $select = ['uuid'];
        //DBからデータを取得
        $store = $this->service->findByPkeyItem($where, false, $select);
        if ($store) {
            return $oldUuid === $store['uuid'];
        } else {
            return false;
        }
    }

    /**
     * 排他削除チェック
     * @param $deleteId
     * @return void | boolean
     */

    protected function isExclusiveDelete($deleteId)
    {
        //DBからデータを取得
        $store = $this->service->repository->setModel()::whereIn('id', $deleteId);
        if ($store && $store->count() === count($deleteId)) {
            return $store;
        } else {
            return false;
        }
    }
}
