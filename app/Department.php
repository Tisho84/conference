<?php

namespace App;

class Department extends ConferenceBaseModel
{
    protected $table = 'department';
    protected $fillable = ['keyword', 'url', 'theme_background_color', 'theme_color', 'image', 'active', 'sort'];

    public function scopeKeyword($query, $keyword)
    {
        return $query->active()
            ->where('keyword', $keyword);
    }
    /*
     * RELATIONS !!!
     */
    public function langs()
    {
        return $this->hasMany('App\DepartmentLang');
    }

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function categories()
    {
        return $this->hasMany('App\Category');
    }
}
