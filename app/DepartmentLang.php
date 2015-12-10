<?php

namespace App;

class DepartmentLang extends ConferenceBaseModel
{
    protected $table = 'department_lang';

    public function department()
    {
        return $this->belongsTo('App\Department');
    }
}
