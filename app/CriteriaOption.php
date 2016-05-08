<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CriteriaOption extends ConferenceBaseModel
{
    protected $table = 'criteria_option';
    protected $fillable = ['criteria_id', 'sort'];
    public $timestamps = false;

    public function langs()
    {
        return $this->hasMany('App\CriteriaOptionLang', 'option_id', 'id');
    }

    public function criteria()
    {
        return $this->belongsTo('App\Criteria');
    }
}
