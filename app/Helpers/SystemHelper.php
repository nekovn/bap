<?php

namespace App\Helpers;

use App\Enums\DefaultDefine;
use App\Models\LogInfo;
use App\Models\Permission;
use App\Models\Role;
use App\Services\LocalFileUploadService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SystemHelper implements SystemHelperInterface
{

    static function encrypt($data, string $passphrase): array
    {
        try {
            $salt = openssl_random_pseudo_bytes(128);//128桁規則
            $iv = openssl_random_pseudo_bytes(16);//16桁規則
            $random = openssl_random_pseudo_bytes(10);//16桁規則
            $iterations = 100;
            $key = hash_pbkdf2("sha512", $passphrase, $salt, $iterations, 128);
            $cipher = openssl_encrypt($data, "AES-256-CBC", hex2bin($key), OPENSSL_RAW_DATA, $iv);
            return [
                "abc" => base64_encode($cipher),
                "zxc" => bin2hex($random),
                "def" => bin2hex($salt),
                "ghi" => bin2hex($iv),
            ];
        } catch (\Exception $exception) {
            self::log(['message' => $exception->getMessage(), 'code' => $exception->getCode()], __METHOD__, __LINE__, 'SystemHelper');
            return [];
        }
    }

    static function decrypt(string $cipher, string $passphrase, string $salt, string $iv)
    {
        try {
            $iterations = 100;
            $key = hash_pbkdf2("sha512", $passphrase, hex2bin($salt), $iterations, 128);
            return openssl_decrypt(base64_decode($cipher), "AES-256-CBC", hex2bin($key), OPENSSL_RAW_DATA, hex2bin($iv));
        } catch (\Exception $exception) {
            self::log(['message' => $exception->getMessage(), 'code' => $exception->getCode()], __METHOD__, __LINE__, 'decrypt');
            return [];
        }
    }


    static function response(int $status = 0, string $message = '', array $data = []): array
    {
        return compact(["status", "message", "data"]);
    }


    static function log(array $exception, string $method, string $line, string $region)
    {
        LogInfo::createLog($exception, $method, $line, $region);
        abort(500);
    }

    /**
     * バリデーションのデータ取得
     * @param $request
     * @return array
     */
    static function getValidationData($request):array
    {
        $requestData = $request->all();
        $target = $requestData['target'] ?? [];
        $decode = json_decode($target, true);
        if ($decode) {
            //Bearer
            $bearer = $request->bearerToken();
            $publicKey = self::getUUid();
            //秘密キー
            $secretKey = config('app.secret');
            //パスフレーズ
            $passphrase = "{$secretKey}-{$publicKey}";
            $decrypt = SystemHelper::decrypt($decode['qer'], $passphrase, $decode['adf'], $bearer);
            $decrypt = json_decode($decrypt, true);
            return !is_null($decrypt) ? $decrypt : [];
        } else {
            return [];
        }
    }

    /**
     * uuid取得する
     * @return string
     */
    static function getUUid(): string
    {
        return Auth::check() ? Auth::user()->uuid : '';
    }

    /**
     * 権限取得する
     * @return array
     */
    static function getRoles(): array
    {
        if (Auth::check()){
            $permissionId = Auth::user()->permissions;
            $permission = Permission::find($permissionId);
            $role = $permission->roles()->get()->toArray();
            //['SELECT', 'INSERT', 'UPDATE', 'DELETE']
            return count($role) ? array_column($role, 'name') : [];
        } else {
            return [];
        }
    }

    /**
     * 元ファイルを削除する
     * @param $path //アドレス
     * @param $disk //ドライバー
     * @param $oldFileName //元ファイル名
     * @return void
     */
    static function deleteOldFile($path, $disk, $oldFileName)
    {
        if ($oldFileName) {
            Storage::disk($disk)->delete("$path/$oldFileName");
        }

    }

    static function handleFileUpload(array $files): array
    {
        $arrImg = [];
        $path = DefaultDefine::IMAGE_ROOM_PATH;
        $disk = DefaultDefine::IMAGE_DISK_PATH;
        if ($files) {
            foreach ($files as $file) {
                if (is_file($file)) {
                    $fileName = (new LocalFileUploadService($file))
                                ->save($path, $disk)
                                ->getFileName($path);
                    $arrImg[]['name'] = $fileName;
                }
            }
        }
        return $arrImg;
    }

    static function file_integrity($file): string
    {
        $path = public_path($file);
        $hash = base64_encode(hash_file('sha256', $path, true));
        return "sha256-$hash";
    }
}
