<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogInfo extends Model
{
    use BaseModelTrait;
    protected $fillable = ['id', 'message_code', 'file_line', 'screen', 'created_at'];
    protected $table = 'log_info';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $appends = ['button'];

    /**
     * Tbodyのボタン(拝見、編集)
     * @return array
     */
    public function getButtonAttribute()
    {
        $btnSee = config('admin.page.page-setting.button.see');
        return ['see' => $btnSee];
    }

    /**
     * エラーがあれば、ログを記録する
     * @param array $exception メッセージ内容、メッセージコード
     * @param string $method 発生さた関数
     * @param string $line 発生さた行
     * @param string $region 発生さた画面位置
     * @return void
     */
    public static function createLog(array $exception, string $method, string $line, string $region)
    {
        $messages = $exception['message'];
        $code = $exception['code'];
        $values = [
            'message_code' => $messages . "_" . $code,
            'file_line' => $method . "_" . $line,
            'screen' => $region,
        ];
        self::create($values);
    }
}
