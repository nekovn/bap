<?php

namespace App\Repositories;


use App\Models\LogInfo;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait BaseRepositoryTrait
{
    abstract public function getModel();

    /**
     * データを作成する
     * @param array $values
     * @return void
     */
    public function create(array $values)
    {
        DB::beginTransaction();
        try {
            DB::commit();
            if (Auth::check()) {
                $values['created_by'] = Auth::user()->full_name;
                $values['updated_by'] = Auth::user()->full_name;
            }
            return $this->getModel()->create($values);
        } catch (\Exception $exception) {
            DB::rollBack();
            LogInfo::createLog(['message' => $exception->getMessage(), 'code' => $exception->getCode()], __METHOD__, __LINE__, $this->screen);
        }

    }

    /**
     * データを作成してID取得
     * @param array $values
     * @return void
     */
    public function inset(array $values)
    {
        $this->getModel()->insertGetId($values);
    }

    /**
     * 更新する。
     * @param array $values 更新カラムの情報。[[key => value], ・・・]
     * @param string $id
     * @return bool
     */
    public function update(array $values, string $id): bool
    {
        DB::beginTransaction();
        try {
            if (Auth::check()) {
                $values['updated_by'] = Auth::user()->full_name;
                $values['updated_at'] = now();
                //ログインしたユーザーのuuidを変更する
                Auth::user()->updateUuid();
            }
            $model = $this->getModel();
            $model->find($id);
            $result = $model->update($values);
            DB::commit();
            return $result;
        } catch (\Exception $exception) {
            DB::rollBack();
            LogInfo::createLog(['message' => $exception->getMessage(), 'code' => $exception->getCode()], __METHOD__, __LINE__, $this->screen);
            return false;
        }

    }

    /**
     * 主キーを基にデータを取得する。
     *
     * @param array $where where句に指定する条件を定義。
     * @param boolean $includeInActive 無効なデータを対象とするか。未指定の場合、is_deleted = 0のデータを対象とする。
     * @param array $select 'select' => ['id as id', ...] 取得項目を指定する。未指定の場合、全項目を取得する。
     * @return array 取得結果
     */
    public function findByPkey(array $where, bool $includeInActive = false, array $select = ['*'], $with = ''): array
    {
        try {
            //selectするので、getModel()を利用
            $model = $this->setModel();
            // where句
            $model = $model->where($where);
            // select句
            $model = $model->select($select);
            // 無効データ取得
            if ($includeInActive) {
                $model = $model->withTrashed();
            }
            if ($with) {
                $result = $model->with($with)->first();
            } else {
                $result = $model->first();
            }
            if (!$result) {
                abort(500);
            }
            return $result->toArray();
        } catch (\Exception $exception) {
            DB::rollBack();
            LogInfo::createLog(['message' => $exception->getMessage(), 'code' => $exception->getCode()], __METHOD__, __LINE__, $this->screen);
            return [];
        }
    }

    /**
     * 指定条件を基にデータを取得する。
     * 検索条件は全てANDとする。ORや副問い合わせ等が必要なクエリーは各Repositoryクラスに記載する。
     *
     * @param array $conditions クエリーを発行する条件を指定する。
     *              ['where' => [['id',1], ...],       where句に指定する条件を定義。未指定の場合、全件取得となる。
     *               'includeInActive' => true,           無効なデータを対象とするか。
     *               'order' => [item => asc/desc, ...] ソート順を指定する。指定なしの場合、ソート順なしのクエリーを発行する。
     *               'offset' => 0,                       取得開始位置を指定する。未指定の場合、指定なし
     *               'limit' => 25,                       取得件数の制限を指定する。未指定の場合、指定なし
     *              ]
     * @param boolean $first
     * @return array | void 取得結果
     */
    public function find(array $conditions, bool $first = false): array
    {
        $model = $this->getModel();
        try {
            if ($conditions) {
                foreach ($conditions as $name => $value) {
                    $model = $this->executeQuery($name, $value, $model);
                }
            }
            if ($first) {
                return $model->first()->toArray();
            } else if (isset($conditions['paginate']) || isset($conditions['simplePaginate'])) {
                return $model->toArray();
            } else {
                return $model->get()->toArray();
            }
        } catch (\Exception $exception) {
            LogInfo::createLog(['message' => $exception->getMessage(), 'code' => $exception->getCode()], __METHOD__, __LINE__, $this->screen);
            abort(500);
        }
    }

    /**
     * 項目の合計を取得する
     * @param array $conditions
     * @param $defaultText
     * @return mixed
     */
    public function total(array $conditions = [], $defaultText = '')
    {
        if ($conditions) {
            $model = $this->getModel();
            foreach ($conditions as $name => $value) {
                switch ($name) {
                    case 'select':
                        if ($value) {
                            $model = $model->select($value);
                        }
                        break;
                    case 'selectRaw':
                        if ($value) {
                            $model = $model->selectRaw($value);
                        }
                        break;
                    case 'where':
                        if ($value) {
                            $model = $model->where($value);
                        }
                        break;
                    case 'groupBy';
                        if ($value) {
                            $model = $model->groupBy($value);
                        }
                        break;
                    default:
                        break;
                }
            }
            $result = $model->cursor()->first();
            if ($result) {
                return $result->toArray();
            } else {
                return ['number' => 0, 'status_name' => $defaultText];
            }

        }
        return $this->getModel()->count();
    }

    /**
     * 検索機能
     * @param $keyword
     * @param $search
     * @return array|mixed|void
     */
    public function search($keyword, $search)
    {
        $data = [];
        try {
            if (is_array($keyword)) {
                foreach ($keyword as $k) {
                    if ($k != "") {
                        $data = $this->whereRawSearch($search, $k);
                    } else {
                        return [];
                    }
                }
            } else {
                $data = $this->whereRawSearch($search, $keyword);
            }
            if ($data) {
                return $data->get()->toArray();
            }
        } catch (\Exception $exception) {
            LogInfo::createLog(['message' => $exception->getMessage(), 'code' => $exception->getCode()], __METHOD__, __LINE__, $this->screen);
            abort(500);
        }
    }

    /**
     * 項目Query
     * @param $search
     * @param $keyword
     * @return mixed
     */
    public function whereRawSearch($search, $keyword)
    {
        $model = $this->getModel();
        foreach ($search as $name => $value) {
            $model = $this->executeQuery($name, $value, $model, $keyword);
        }
        return $model;
    }

    /**
     * 検索Queryを設定 CONCAT(A,B,C) LIKE (CONCAT('%', ?, '%')) => ABC LIKE %?% ;
     * @param $search
     * @return string
     */
    public function setQueryConcat($search): string
    {
        $concat = "CONCAT(";
        foreach ($search as $key => $s) {
            $concat .= "ifnull(LCASE($s),'')";
            $concat .= (count($search) - 1) == $key ? '' : ',';
        }
        $concat .= ') LIKE CONCAT(\'%\', ?,\'%\')';
        return $concat;
    }

    /**
     * Query文を実行する
     * @param $name
     * @param $value
     * @param $model
     * @param string $keyword
     * @return mixed
     */
    private function executeQuery($name, $value, $model, string $keyword = '')
    {
        switch ($name) {
            case 'search':
                if ($keyword) {
                    $concat = $this->setQueryConcat($value);
                    $model = $model->whereRaw($concat,
                        str_replace(array('\\', '%', '_'), array('\\\\', '\%', '\_'), $keyword)
                    );
                }
                break;
            case 'where':
                if ($value) {
                    $model = $model->where($value);
                }
                break;
            case 'whereBetween':
                if ($value) {
                    foreach ($value as $column => $date) {
                        $model = $model->whereBetween($column, $date);
                    }
                }
                break;
            case 'trashed':
                $model = $model->withTrashed();
                break;
            case 'order':
                if ($value) {
                    foreach ($value as $key => $order) {
                        $model = $model->orderBy($key, $order);
                    }
                }
                break;
            case 'paginate':
                if ($value) {
                    $model = $model->paginate($value);
                }
                break;
            case 'simplePaginate':
                if ($value) {
                    $model = $model->simplePaginate($value);
                }
                break;
            case 'offset':
                if ($value) {
                    $model = $model->skip($value);
                }
                break;
            case 'limit':
                if ($value) {
                    $model = $model->take($value);
                }
                break;
            default:
                break;
        }

        return $model;
    }


    /**
     * データを削除する
     * @param array $conditions
     * @return false|void
     */
    public function delete(array $conditions = [])
    {
        $model = $this->getModel();
        return $this->executeDelete($model, $conditions);
    }

    /**
     * 削除実行
     * @param $model
     * @param $conditions
     * @return mixed|void
     */
    public function executeDelete($model, $conditions)
    {
        DB::beginTransaction();
        try {
            return $model->whereIn('id', $conditions['id'])->chunk(10, function ($model) {
                foreach ($model as $attribute) {
                    $attribute->delete();
                    DB::commit();
                }
            });
        } catch (\Exception $exception) {
            DB::rollBack();
            LogInfo::createLog(['message' => $exception->getMessage(), 'code' => $exception->getCode()], __METHOD__, __LINE__, $this->screen);
            abort(500);
        }
    }

    /**
     * 最新の作成日付を取得する
     * @param $column
     * @return mixed
     */
    public function getLastRow($column)
    {
        $data = $this->getModel()->latest($column)->first();
        if ($data) {
            $data = $data->toArray();
            return $data['created_at'];
        } else {
            return null;
        }
    }
}
