<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CriteriaLang extends ConferenceBaseModel
{
    protected $table = 'criteria_lang';
    protected $fillable = ['lang_id', 'title'];
    public $timestamps = false;

    public function criteria()
    {
        return $this->belongsTo('App\Criteria');
    }
}
