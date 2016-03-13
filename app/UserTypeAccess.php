<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTypeAccess extends Model
{
    public $fillable = ['access_id', 'user_type_id'];
    public $timestamps = false;
    protected $table = 'user_type_access';
}
