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
}
