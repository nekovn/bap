<?php

namespace App\Http\Controllers\Admin\Container;

interface DefineInterface
{
    /**
     * インスタンス設定
     * @return mixed
     */
    public function instance();

    /**
     * クライアントに返すinputのhtmlの定数情報を取得する
     * @return array
     */
    public function getInputForm(): array;

    /**
     * コード配列を取得する
     * @param $code
     * @return array
     */
    public function getValue($code): array;

}
