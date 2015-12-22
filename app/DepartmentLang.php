<?php

namespace App;

class DepartmentLang extends ConferenceBaseModel
{
    protected $table = 'department_lang';
    protected $fillable = ['lang_id', 'name', 'title', 'description'];
    public $timestamps = false;

    public function department()
    {
        return $this->belongsTo('App\Department');
    }
}
