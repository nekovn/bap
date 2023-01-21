<?php

namespace App\Models;

use App\Enums\CodeDefine;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'room';
    protected $fillable = ['room_number', 'title', 'description', 'address', 'district_id', 'price', 'acreage', 'point',
        'star_id', 'hot_id', 'exist', 'status_id', 'created_at'];


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
        ])->update(['exist' => CodeDefine::ACTIVE_VALUE]);
    }
}
