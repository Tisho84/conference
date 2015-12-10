<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LanguageModel extends Model
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
}