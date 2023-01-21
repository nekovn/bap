<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;

class Flash
{
    /**
     * (32) 1321-3123 -> 3232131231
     * @param $value
     * @return string|string[]|null
     */

    static function convertFormatPhone($value)
    {
        return $value ? str_replace(["(", ")", "-", " "], "", $value) : null;
    }

    /**
     * 1231232131 -> 1231-232-131
     * @param $value
     * @return array|string|string[]|null
     */
    static function addDashesToPhone($value)
    {
        return preg_replace("/^(\d{4})(\d{3})(\d{3,4})$/", "$1-$2-$3", $value);
    }

    static function deleteOldImage($path, $disk, $oldImage)
    {
        if ($oldImage) {
            Storage::disk($disk)->delete($path . '/' . $oldImage);
        }
    }

    /**
     * ['room_name' => 'A01'] => ['room_id' => 'A01']
     * @param $array
     * @param $keyName
     * @return mixed
     */
    static function changeKeyNameInArray($array, $keyName)
    {
        foreach ($array as $key => $value) {
            if($key && $value) {
                if (array_key_exists($key, $keyName)) {
                    $keyNew = $keyName[$key];
                    $array[$keyNew] = $value;
                    unset($array[$key]);
                }
            }

        }
        return $array;
    }

    /**
     * @param string $msg_cd
     * @param $parameters
     * @return string
     */
    public static function getMessage(string $msg_cd, $parameters = []): string
    {
        return self::bindParameter(Lang::get($msg_cd), $parameters);
    }

    /**
     * 文字列のパラメータ部にバインドパラメータを設定する。
     * @param string $source
     * @param array $parameters
     * @return string
     * ex: self::getMessage('messages.W.search.count.limit.over', ['count' => $limit]);
     */
    public static function bindParameter(string $source, array $parameters = []): string
    {
        //該当件数が多すぎます。<br>:count件以下となるように、検索条件を指定して再検索を行ってください。
        $string = $source;
        if (empty($parameters)) {
            return $string;
        }
        foreach ($parameters as $key => $value) {
            $string = str_replace(":{$key}", $value, $string);
        }

        return $string;
    }
}
