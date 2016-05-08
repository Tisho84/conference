<?php

namespace App;

use App\Classes\CriteriaType;
use Illuminate\Database\Eloquent\Model;

class Criteria extends ConferenceBaseModel
{
    protected $table = 'criteria';
    protected $fillable = ['department_id', 'type_id', 'sort'];
    public $timestamps = false;

    public function langs()
    {
        return $this->hasMany('App\CriteriaLang');
    }

    public function options()
    {
        return $this->hasMany('App\CriteriaOption');
    }

    public function department()
    {
        return $this->belongsTo('App\Department');
    }

    public function getTypeAttribute()
    {
        $type = new CriteriaType();
        return $type->getType($this->attributes['type_id']);
    }
}
