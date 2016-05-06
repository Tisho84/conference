<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    protected $table = 'criteria';
    protected $fillable = ['department_id', 'type_id', 'vars', 'sort'];

    public function langs()
    {
        return $this->hasMany('App\CriteriaLang');
    }

    public function department()
    {
        return $this->belongsTo('App\Department');
    }
}
