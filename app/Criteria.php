<?php

namespace App;

use App\Classes\CriteriaType;
use Illuminate\Database\Eloquent\Model;

class Criteria extends ConferenceBaseModel
{
    protected $table = 'criteria';
    protected $fillable = ['department_id', 'type_id', 'required', 'visible', 'admin', 'sort'];
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

    public function papers()
    {
        return $this->belongsToMany('App\Paper', 'criteria_paper', 'criteria_id', 'paper_id')->withPivot('value');
    }

    public function getTypeAttribute()
    {
        $type = new CriteriaType();
        return $type->getType($this->attributes['type_id']);
    }

    public function build()
    {
        $type = new CriteriaType($this);
        return $type->build();
    }
}
