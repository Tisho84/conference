<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends ConferenceBaseModel implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'department_id', 'user_type_id', 'rank_id', 'country_id',
        'phone', 'address', 'institution', 'active',
        'name', 'email', 'email2', 'password', 'is_reviewer'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function department()
    {
        return $this->belongsTo('App\Department');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category', 'user_category', 'user_id', 'category_id');
    }

    public function type()
    {
         return $this->belongsTo('App\UserType', 'user_type_id', 'id', 'user_type');
    }
}
