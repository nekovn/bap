<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Utilities extends Model
{
    protected $fillable = ['id', 'name', 'sequence', 'code', 'status'];
    protected $table = 'utilities';

    public function scopeGetUtilities($query, $code)
    {
        return $query->select(['id as key', 'name as value'])->where([
            'code' => $code
        ])->orderBy('sequence')->get()->toArray();
    }


}
