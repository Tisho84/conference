<?php

namespace App;

use App\Interfaces\ILanguageModel;

class DepartmentLang extends BaseModel implements ILanguageModel
{
    protected $table = 'department_lang';

    public function department()
    {
        return $this->belongsTo('App\Department');
    }
}
