<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomImage extends Model
{
    use BaseModelTrait;
    protected $table = 'room_image';
    protected $fillable = ['name'];
    protected $visible = ['id', 'name'];
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = false;
}
