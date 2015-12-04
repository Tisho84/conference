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

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeSort($query)
    {
        return $query->orderBy('sort');
    }

    /*
     * RELATIONS !!!
     */
    public function langs()
    {
        return $this->hasMany('App\DepartmentLang');//->addEagerConstraints('App\DepartmentLang')->lists('title', 'lang_id');
    }
}
