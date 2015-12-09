<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public function scopeLang($query,  $id = null)
    {
        if ( !$id ) {
            $id = dbTrans();
        } else {
            $id = is_numeric($id) ? $id : dbTrans($id);
        }
        return $query->where('lang_id', $id);
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeSort($query)
    {
        return $query->orderBy('sort');
    }
}