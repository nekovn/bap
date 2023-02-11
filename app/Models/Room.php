<?php

namespace App\Models;

use App\Enums\CodeDefine;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Room extends Model
{
    use BaseModelTrait;

    protected $fillable = ['room_number', 'title', 'description', 'address', 'district_id', 'price', 'acreage',
        'star', 'hot_id', 'exist_id', 'status_id', 'created_by', 'updated_by'];
    protected $appends = ['button'];
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'room';

    public function getButtonAttribute()
    {
        $btnSee = config('admin.page.page-setting.button.see');
        $btnEdit = config('admin.page.page-setting.button.edit');
        return ['see' => $btnSee, 'edit' => $btnEdit];
    }

    /**
     * room番号を取得する
     * @param $query
     * @return mixed
     */
    public function scopeGetRoomNumber($query)
    {
        return $query->select(['room_number as value', 'district_id as target'])->where([
            'status_id' => CodeDefine::ACTIVE_VALUE,
        ])->get()->toArray();
    }

    /**
     * 部屋の既存を設定する
     * @param $query
     * @param $room_number
     * @param $district_id
     * @return mixed
     */
    public function scopeSetExistsRoom($query, $room_number, $district_id)
    {
        return $query->where([
            'room_number' => $room_number,
            'district_id' => $district_id
        ])->update(['exist_id' => CodeDefine::ACTIVE_VALUE]);
    }

    public function districtId()
    {
        return $this->belongsTo(CodeValue::class, 'district_id', 'key')
            ->select(['key', 'value'])
            ->where('code_id', CodeDefine::CODE_DISTRICT);
    }

    public function hotId()
    {
        return $this->belongsTo(CodeValue::class, 'hot_id', 'key')
            ->select(['key', 'value'])
            ->where('code_id', CodeDefine::CODE_HOT);
    }

    public function existId()
    {
        return $this->belongsTo(CodeValue::class, 'exist_id', 'key')
            ->select(['key', 'value'])
            ->where('code_id', CodeDefine::CODE_ROOM_EXIST);
    }

    public function statusId()
    {
        return $this->belongsTo(CodeValue::class, 'status_id', 'key')
            ->select(['key', 'value'])
            ->where('code_id', CodeDefine::CODE_STATUS);
    }

    public function image()
    {
        return $this->hasMany(RoomImage::class, 'room_id', 'id');
    }

    public function utilities($code = CodeDefine::UTILITY_ROOM)
    {
        return $this->belongsToMany(Utilities::class, 'room_utilities', 'room_id', 'utilities_id')
            ->select(['utilities.name as value', 'utilities.id as key'])
            ->where('code', $code);
    }

    public function utility_room()
    {
        return $this->utilities();

    }

    public function space_room()
    {
        return $this->utilities(CodeDefine::SPACE_ROOM);

    }

    public function space_share()
    {
        return $this->utilities(CodeDefine::SPACE_SHARE);

    }
}
