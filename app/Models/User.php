<?php

namespace App\Models;
use App\Enums\CodeDefine;
use App\Enums\DefaultDefine;
use App\Notifications\Admin\TwoFactorCode;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;


class User extends Authenticatable implements CanResetPassword
{
    use BaseModelTrait;
    use AuthenticationModelTrait;
    use MustVerifyEmail, Notifiable;

    protected $fillable = ['id', 'code', 'full_name', 'gender', 'birthday', 'address', 'phone', 'email', 'password', 'two_factor_code', 'two_factor_expires_at',
        'permissions', 'is_block', 'remark', 'remember_token', 'email_verified_at', 'uuid', 'is_delete', 'created_by', 'updated_by'];
    protected $hidden = ['remember_token', 'email_verified_at', 'two_factor_expires_at'];
    protected $casts = ['email_verified_at' => 'datetime', 'two_factor_expires_at' => 'datetime'];
    protected $appends = ['button'];
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    public function getButtonAttribute()
    {
        $btnSee = config('admin.page.page-setting.button.see');
        $btnEdit = config('admin.page.page-setting.button.edit');
        return ['see' => $btnSee, 'edit' => $btnEdit];
    }

    public function sendEmailTwoFactorNotification()
    {
        $this->notify(new TwoFactorCode());
    }

    /**
     * ２回目認証を初期化に作成する
     * @return void
     */
    public function generateTwoFactorCode()
    {
        $this->timestamps = false;
        $this->two_factor_code = rand(100000, 999999);
        $this->two_factor_expires_at = now()->addMinutes(DefaultDefine::EXPIRE);
        $this->save();
    }

    /**
     * ２回目認証を初期化に再現する
     * @return void
     */
    public function resetTwoFactorCode()
    {
        $this->timestamps = false;
        $this->two_factor_code = null;
        $this->two_factor_expires_at = null;
        $this->save();
    }

    public function updateUuid()
    {
        $this->uuid = Str::uuid();
        $this->save();
    }

    public function permissions() {
        return $this->belongsTo(Permission::class, 'permissions', 'id');
    }

    public function gender()
    {
        return $this->belongsTo(CodeValue::class, 'gender', 'key')
            ->select(['key', 'value'])
            ->where('code_id', CodeDefine::CODE_GENDER);
    }

    public function isBlock()
    {
        return $this->belongsTo(CodeValue::class, 'is_block', 'key')
            ->select(['key', 'value'])
            ->where('code_id', CodeDefine::CODE_BLOCK);
    }

    public function isDelete()
    {
        return $this->belongsTo(CodeValue::class, 'is_delete', 'key')
            ->select(['key', 'value'])
            ->where('code_id', CodeDefine::CODE_DELETE);
    }
}
