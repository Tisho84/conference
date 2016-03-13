<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserType extends ConferenceBaseModel
{
    protected $table = 'user_type';
    protected $fillable = ['title', 'active', 'sort'];
    public $timestamps = false;

    /*
     * RELATIONS !!!
     */

    public function users()
    {
        return $this->hasMany('App\User', 'id', 'user_type_id');
    }

    public function access()
    {
        return $this->hasMany('App\UserTypeAccess', 'user_type_id', 'id');
    }
}
