<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $table = 'settings';
    protected $fillable = ['department_id', 'key', 'value'];
    public $timestamps = false;

    public function department()
    {
        return $this->belongsTo('App\Department');
    }

    public function scopeKey($query, $key)
    {
        return $query->where('key', $key)->first();
    }
}

