<?php

namespace App\Models;

use App\Enums\CodeDefine;
use DateTimeInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

trait BaseModelTrait
{

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (isset($model->uuid)) {
                $model->uuid = Str::uuid();
            }
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid();
            }
        });

        static::deleting(function ($model) {
            if (isset($model->room_number) && isset($model->room_district)) {
                if ($model->room_number && $model->room_district) {
                    Room::where(['district_id' => $model->room_district, 'room_number' => $model->room_number])
                        ->update(['exist' => CodeDefine::INACTIVE_VALUE]);
                }
            }
        });
    }

    /**
     * 書式変換を行う
     * https://laravel.com/docs/7.x/eloquent-serialization
     * 2022-07-24T11:22:08.000000Z -> 2022-07-24 18:22:08　
     */
    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }


}
