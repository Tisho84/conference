<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends ConferenceBaseModel
{
    protected $table = 'news';
    protected $fillable = ['department_id', 'active', 'sort'];
    public $dates = ['created_at', 'updated_at'];

    public function langs()
    {
        return $this->hasMany('App\NewsLang');
    }

    public function department()
    {
        return $this->belongsTo('App\Department');
    }
}
