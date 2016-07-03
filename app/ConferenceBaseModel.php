<?php

namespace App;

use Carbon\Carbon;
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

    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('d.m.Y H:i');
    }

    public function getUpdatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('d.m.Y H:i');
    }

    public function setSortAttribute($value)
    {
        if (!$value) {
            $value = calcSort($this::max('sort'));
        }
        $this->attributes['sort'] = $value;
    }
}
