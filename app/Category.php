<?php

namespace App;

class Category extends ConferenceBaseModel
{
    protected $table = 'category';
    protected $fillable = ['department_id', 'active', 'sort'];
    protected $dates = ['created_at', 'updated_at'];

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
