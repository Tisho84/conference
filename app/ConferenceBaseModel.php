<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConferenceBaseModel extends Model
{
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeSort($query)
    {
        return $query->orderBy('sort');
    }

    public function scopeLang($query)
    {
        return $query->where('lang_id', dbTrans());
    }

//    public function getActiveAttribute($value)
//    {
//        return $value ? trans('static.yes') : trans('static.no');
//    }

    public function setSortAttribute($value)
    {
        if (!$value) {
            $value = calcSort($this::max('sort'));
        }
        $this->attributes['sort'] = $value;
    }
}
