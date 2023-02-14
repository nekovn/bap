<?php

namespace App\Http\Controllers;

use App\Enums\DefaultDefine;
use App\Helpers\SystemHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

trait BaseControllerTrait
{
    /**
     * リストを表示する
     * @param Request $request
     * @return InertiaResponse
     */
    protected function index(Request $request): InertiaResponse
    {
        //条件を設定する
        $conditions = ['where' => [], 'order' => ['created_at' => $this->defaultSort], 'simplePaginate' => $this->defaultPerPage];
        //コンテナからデータを取得する
        $result = $this->getListContainer($conditions);
        //データ暗号化
        $this->data['data'] = SystemHelper::encrypt(json_encode($result), config('app.secret'));
        //属性を設定する
        $this->setAttrs();
        //クライアントにデータを反映する
        return Inertia::render($this->screen, $this->data);
    }

    /**
     * コンテナからデータを取得する
     * @return mixed
     */
    protected function getListContainer($conditions)
    {
        $dataCache = $this->container->getContainer($this->screen);
        //存在すれば、すぐに取得する
        if ($dataCache) {
            return $dataCache;
        } else {
            //存在しない時はDB取って、キャッシュ設定する
            //結果
            $result = $this->service->findItem($conditions);
            //キャッシュ設定
            $this->container->setContainer($this->screen, $result, $result['data']);
            //結果データ取得
            return $result;
        }

    }


    /**
     * 属性を設定する
     * @return void
     */
    protected function setAttrs()
    {
        $count = $this->service->repository->getModel()->count();
        $attrs = [
            'count' => $count,
            'totalPage' => ceil($count / $this->defaultPerPage),
            'tHead' => $this->thead,
            'filter' => $this->filter,
            'showPage' => $this->showPage,
            'searchBy' => $this->searchBy,
            'isActions' => $this->isActions,
            'router' => $this->router,
            'defaultSort' => $this->defaultSort,
            'uuid' => SystemHelper::getUUid()
        ];
        $this->data['attribute'] = SystemHelper::encrypt(json_encode($attrs), config('app.secret'));
    }


    /**
     * Roomリストを取得する
     * @return mixed
     */
    protected function getListRoom()
    {
        $result = $this->service->getListRoom();
        //キャッシュに既存
        $this->container->setContainer(DefaultDefine::CACHE_ROOM, $result, $result);
        //キャッシュからデータ取得
        return $this->container->getContainer(DefaultDefine::CACHE_ROOM);
    }


    /**
     * 定数情報を取得
     * @return mixed
     */
    protected function getDefineData()
    {
        $result = $this->define->getInputForm()[$this->defineName];
        //キャッシュに既存
        $this->container->setContainer($this->defineName, $result, $result);
        //キャッシュからデータ取得
        return $this->container->getContainer($this->defineName);
    }


    /**
     * バリデーション属性取得
     * @param $validation
     * @return array
     */
    protected function getAttributeValidation($validation): array
    {
        //リクエストデータ
        $requestData = $validation->validationData();
        //validatedデータ
        $validatedData = $validation->validated();
        return $this->isValidAPI($requestData, $validatedData);
    }


    /**
     * 有効APIをチェックする
     * @param $requestData
     * @param $validatedData
     * @return array
     */
    private function isValidAPI($requestData, $validatedData): array
    {
        //リクエストデータがない時
        if (!$validatedData || !$requestData) {
            return SystemHelper::response(DefaultDefine::STATUS_UNAUTHORIZED, __('messages.errors_unauthorized'));
        }
        //有効期限チェック
        $stampTime = $requestData['stampTime'] ?? 0;
        $nowTime = strtotime(now());
        if ($nowTime - $stampTime > 1) {
            //現在日付 - 過去日付 > 1　=> 無効
            return SystemHelper::response(DefaultDefine::STATUS_UNAUTHORIZED, __('messages.errors_unauthorized'));
        }
        //nonceチェック（有効が一回だけ）
        $nonce = $requestData['nonce'];
        if (Session::has($nonce)) {
            return SystemHelper::response(DefaultDefine::STATUS_UNAUTHORIZED, __('messages.errors_unauthorized'));
        }
        //nonce存在しない時、設定する
        Session::push($nonce, true);
        //条件を設定する
        $conditions = $this->setConditionForItem($requestData);
        return compact(["conditions", "validatedData", "requestData"]);
    }

    /**
     * プロセスの成功を処理する
     * @param $validation
     * @param $crudName
     * @return array
     */
    protected function handleProcessSuccess($validation, $crudName):array
    {
        //バリデーション属性取得
        $attrs = $this->getAttributeValidation($validation);
        if (!isset($attrs['validatedData'])) {
            //エラーのレスポンス
            return $attrs;
        } else {
            //有効が一回だけを削除する
            $this->flushNonceKey($validation->validationData());
            //レスポンスデータ
            return $this->$crudName($attrs['conditions'], $attrs['validatedData'], $attrs['requestData']);
        }
    }

    /**
     * 有効が一回だけを削除する
     * @param $validationData
     * @return void
     */
    protected function flushNonceKey($validationData)
    {
        Session::forget($validationData['nonce']);
    }
}
