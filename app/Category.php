<?php

namespace App;

class Category extends ConferenceBaseModel
{
    protected $table = 'category';
    /*
     * RELATIONS !!!
     */
    public function langs()
    {
        return $this->hasMany('App\CategoryLang');
    }

    public function department()
    {
        return $this->belongsTo('App\Department');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'user_category', 'category_id', 'user_id');
    }
}
