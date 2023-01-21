<?php

namespace App\Http\Controllers\Admin\Filter;

use App\Enums\DefaultDefine;
use App\Helpers\SystemHelper;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;

trait FilterTrait
{
    /**
     * レスポンスのデータ設定
     * @param $result
     * @param $message
     * @return array
     */
    protected function setResponseFilter($result, $message): array
    {
        //正常の時
        if ($result) {
            $result = SystemHelper::encrypt(json_encode($result), config('app.secret'));
            //レスポンスデータ
            $response = SystemHelper::response(DefaultDefine::STATUS_SUCCESS, $message, $result);
        } else {
            //レスポンスError
            $response = SystemHelper::response(DefaultDefine::STATUS_NOT_FOUND, __('messages.search_not_data'));
        }

        return $response;
    }

    /**
     * 日付検索
     * @param $data
     * @return array
     */
    protected function filterDate($data): array
    {
        //開始時間
        $dateStart = $data['dateStart'] ?? '';
        //終了時間
        $dateEnd = $data['dateEnd'] ?? '';
        //処理
        if ($dateStart && $dateEnd) {
            $formatDateStart = date('Y-m-d', strtotime($dateStart));
            $formatDateEnd = date('Y-m-d', strtotime($dateEnd));
            //終了時間 >=　開始時間
            if ($formatDateEnd >= $formatDateStart) {
                return ['created_at' => [$formatDateStart, $formatDateEnd]];
            }
        }
        return [];
    }

    /**
     * 項目に条件を設定する
     * @param $data
     * @return array
     */
    protected function setConditionForItem($data): array
    {
        //条件
        $conditions = [];
        $dateTime = $this->filterDate($data);
        if ($dateTime) $conditions['whereBetween'] = $dateTime;
        //ページネーションフラグ
        $isLimit = $data['isLimit'] ?? false;
        //並び順
        $sort = $data['sort'] ?? '';
        if ($sort) $conditions['order'] = ['created_at' => $sort];
        //1ページあたり
        $per_page = $data['per_page'] ?? '';
        if ($per_page && !$isLimit) $conditions['simplePaginate'] = $per_page;
        //ページネーションをクリックする時
        if ($per_page && $isLimit) $conditions['limit'] = $per_page;
        //ページ位置
        $offset = $data['offset'] ?? '';
        if ($offset) $conditions['offset'] = ((int)$offset - 1) * (int)$per_page;
        return $conditions;
    }

    /**
     * フィルターのプロセスを処理する
     * @param $validation
     * @param string $type
     * @return array
     */
    protected function handleProcessFilter($validation, string $type = 'filter'): array
    {
        //バリデーション属性取得
        $attrs = $this->getAttributeValidation($validation);
        if (!isset($attrs['validatedData'])) {
            return $attrs;
        } else {
            //有効が一回だけを削除する
            $this->flushNonceKey($validation->validationData());
            //成功メソッドを呼び
            $method = ucfirst($type);
            $methodName = "handle{$method}Success";
            //メソッド存在する時：
            if (method_exists($this, $methodName)) {
                //レスポンスデータ
                return $this->$methodName($attrs);
            } else {
                return SystemHelper::response(DefaultDefine::STATUS_406, __('messages.cannot_accept'));
            }
        }
    }

    /**
     * フィルターの成功を処理する
     * @param $attrs
     * @return array
     */
    protected function handleFilterSuccess($attrs): array
    {
        //キーワードがある時：
        if ($attrs['validatedData']['keyword']) {
            //項目を検索する
            $result = $this->searchItem($attrs);
            //レスポンスデータ
            return $this->setResponseFilter($result['data'], '');
        } else {
            //項目をフィルターする
            $result = $this->filterItem($attrs);
            //レスポンスデータ
            return $this->setResponseFilter($result, '');
        }
    }

    /**
     * 項目をフィルターする
     * @param $attrs
     * @return array
     */
    protected function filterItem($attrs): array
    {
        //結果
        $findItem = $this->service->findItem($attrs['conditions']);
        //項目トータル
        $count = $this->service->repository->getModel()->count();
        //1ページあたり
        $per_page = $attrs['validatedData']['per_page'];
        //現在ページ
        $current_page = $attrs['validatedData']['offset'];
        //フィルターの結果を取得する
        return $this->getResultFilterData($per_page, $current_page, $findItem, $count, $attrs['conditions']);
    }

    /**
     * 検索の成功を処理する
     * @param $attrs
     * @return array
     */
    protected function handleSearchSuccess($attrs): array
    {
        //項目を検索する
        $result = $this->searchItem($attrs);
        return $this->setResponseFilter($result['data'], __('messages.success_search', ['count' => $result['count']]));
    }

    /**
     * 項目を検索する
     * @param $attrs
     * @return array
     */
    protected function searchItem($attrs): array
    {
        $attrCondition = $attrs['conditions'];
        //列で検索
        $attrCondition['search'] = $this->searchBy;
        //自由検索
        $keyword = $attrs['validatedData']['keyword'] ?? '';
        $search = explode(" ", trim(preg_replace('/\s+/', " ", $keyword)));
        //条件
        $conditions = Arr::except($attrCondition, ['offset', 'limit']);
        //結果データを返す
        $findItem = $this->getResultSearch($keyword, $search, $conditions);
        //検索項目のトータル
        $count = count($findItem);
        //現在ページ
        $current_page = $attrs['requestData']['offset'] ?? 1;
        //ページネーションの属性を取得する
        $data = $this->setPaginationWhenSearchItem($findItem, $attrCondition['limit'], $attrCondition['offset'], $count, $current_page);
        //レスポンスデータ
        return compact("data", "count");
    }

    /**
     * 検索の結果を取得する
     * @param $keyword
     * @param $search
     * @param $conditions
     * @return mixed
     */
    protected function getResultSearch($keyword, $search, $conditions)
    {
        if (Session::has("$this->screen-search-$keyword")) {
            $sessionData = Session::get("$this->screen-search-$keyword");
            $findItem = array_shift($sessionData);
        } else {
            //普通にデータを検索する
            $findItem = $this->service->searchItem($search, $conditions);
            //Session保存する
            Session::push($keyword, $findItem);
        }
        return $findItem;
    }

    /**
     * 検索の結果が出る時、ページネーションがあれば、設定する
     * @param $findItem
     * @param $limit
     * @param $offset
     * @param $count
     * @param $current_page
     * @return array
     */
    protected function setPaginationWhenSearchItem($findItem, $limit, $offset, $count, $current_page): array
    {
        //ページネーションの属性を取得する
        $attrs = $this->setAttrPagination($limit, $current_page, $count);
        $result['data'] = array_splice($findItem, $offset, $limit);
        return array_merge($result, $attrs);
    }


    /**
     * フィルターの結果を取得する
     * @param $per_page
     * @param $current_page
     * @param $findItem
     * @param $count
     * @param $conditions
     * @return array
     */
    protected function getResultFilterData($per_page, $current_page, $findItem, $count, $conditions): array
    {
        //ページネーションの属性を取得する
        $attrs = $this->setAttrPagination($per_page, $current_page, $count);
        //項目を検索した結果を取得する
        $result = $this->getSuccessFromFindItem($findItem, $attrs, $conditions, $per_page);
        return array_merge($result, $attrs);
    }

    /**
     * 項目を検索した結果を取得する
     * @param $findItem
     * @param $attrs
     * @param $conditions
     * @param $per_page
     * @return array
     */
    protected function getSuccessFromFindItem($findItem, $attrs, $conditions, $per_page): array
    {
        //データはオバーする時：
        if (isset($attrs['isOver'])) {
            $conditions['offset'] = ((int)$attrs['current_page'] - 1) * (int)$per_page;
            $result['data'] = $this->service->findItem($conditions);;
        } else {
            //普通処理する
            $result['data'] = $findItem;
        }
        return $result;
    }

    /**
     * ページネーションに属性を設定する
     * @param $per_page
     * @param $current_page
     * @param $count
     * @return array
     */
    protected function setAttrPagination($per_page, $current_page, $count): array
    {
        $attr = [];
        //トータル設定
        if (isset($per_page) && $per_page) {
            //項目トータル
            $attr['count'] = $count;
            //ページトータル
            $attr['totalPage'] = ceil($count / $per_page);
        }
        if (isset($current_page) && $current_page) {
            //現在ページ
            $attr['current_page'] = (int)$current_page;
        }
        //現在ページ > トータルページ
        if ($attr['current_page'] > $attr['totalPage']) {
            $attr['current_page'] = (int)$attr['totalPage'];
            $attr['isOver'] = true;
        }
        return $attr;
    }

}
