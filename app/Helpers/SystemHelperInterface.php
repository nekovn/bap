<?php

namespace App\Helpers;

interface SystemHelperInterface
{
    /**
     * データを暗号化する
     * @param $data
     * @param string $passphrase 秘密キー
     * @return array
     */
    static function encrypt($data, string $passphrase): array;

    /**
     * 復号
     * @param string $cipher データをエンコードされた暗号
     * @param string $passphrase 秘密キー
     * @param string $salt ランダムの128桁規則
     * @param string $iv ランダムの16桁規則
     * @return mixed
     */
    static function decrypt(string $cipher, string $passphrase, string $salt, string $iv);

    /**
     * クライアントに返すレスポンス配列設定
     * @param int $status
     * @param string $message
     * @param array $data
     * @return array
     */
    static function response(int $status = 0, string $message = '', array $data = []): array;

    /**
     * ログ記録
     * @param array $exception メッセージ内容、メッセージコード
     * @param string $method 発生さた関数
     * @param string $line 発生さた行
     * @param string $region 発生さた画面位置
     * @return void
     */
    static function log(array $exception, string $method, string $line, string $region);
}
