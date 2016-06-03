<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $table = 'email_template';
    public $timestamps = false;
    protected $fillable = [
        'department_id', 'name', 'subject', 'body', 'system'
    ];

    public function department()
    {
        return $this->belongsTo('App\Department');
    }
}
