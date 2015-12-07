<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DepartmentLang extends Model
{
    protected $table = 'department_lang';

    public function scopeLang($query,  $id = null)
    {
        if ( !$id ) {
            $id = dbTrans();
        } else {
            $id = is_numeric($id) ? $id : dbTrans($id);
        }
        return $query->where('lang_id', $id);
    }

    public function department()
    {
        return $this->belongsTo('App\Department');
    }
}
