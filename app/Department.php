<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'department';

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
