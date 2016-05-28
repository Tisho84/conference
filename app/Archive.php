<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Archive extends ConferenceBaseModel
{
    protected $table = 'archive';
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = [
        'department_id', 'name'
    ];

    public function papers()
    {
        return $this->hasMany('App\Paper');
    }

    public function department()
    {
        return $this->belongsTo('App\Department');
    }

}
