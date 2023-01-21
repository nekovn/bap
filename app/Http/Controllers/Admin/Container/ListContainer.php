<?php

namespace App\Http\Controllers\Admin\Container;

use App\Enums\DefaultDefine;
use Illuminate\Support\Facades\Cache;

class ListContainer
{
    public $cache;

    /**
     * インスタンス設定
     * @return $this
     */
    public function instance(): ListContainer
    {
        return $this;
    }

    /**
     * キャッシュに既存
     * @param $name //キャッシュ名
     * @param $container //データ
     * @param $condition //条件
     * @return void
     */
    public function setContainer($name, $container, $condition)
    {
        //存在すろこと、かつは、データあること
        if ($name && $condition) {
            Cache::remember($name, 60*60*24, function () use ($container) {
                return $container;
            });
        } else {
            //Case削除
            $this->destroy($name);
        }
    }

    /**
     * キャッシュからデータ取得
     * @param $name //キャッシュ名
     * @return mixed
     */
    public function getContainer($name)
    {
        return Cache::get($name);
    }

    /**
     * キャッシュ削除
     * @return void
     */
    public function destroy($key)
    {
        Cache::forget($key);
    }

}
