<?php

namespace App\Models;

use App\Enums\CodeDefine;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use AuthenticationModelTrait;
    use BaseModelTrait;

    protected $fillable = ['id', 'customer_type', 'full_name', 'gender', 'birthday', 'address', 'phone', 'email', 'account', 'password',
        'is_block', 'remark', 'room_number', 'room_district', 'remember_token', 'email_verified_at', 'uuid', 'is_delete', 'created_by', 'updated_by'];
    protected $appends = ['button'];
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $table = 'customers';

    public function getButtonAttribute()
    {
        $btnSee = config('admin.page.page-setting.button.see');
        $btnEdit = config('admin.page.page-setting.button.edit');
        return ['see' => $btnSee, 'edit' => $btnEdit];
    }

    public function scopeListRoom()
    {
        return Room::GetRoomNumber();
    }

    public function customerType()
    {
        return $this->belongsTo(CodeValue::class, 'customer_type', 'key')
            ->select(['key', 'value'])
            ->where('code_id', CodeDefine::CUSTOMER_TYPE);
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

    public function roomDistrict()
    {
        return $this->belongsTo(CodeValue::class, 'room_district', 'key')
            ->select(['key', 'value'])
            ->where('code_id', CodeDefine::CODE_DISTRICT);
    }
}
