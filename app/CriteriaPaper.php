<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CriteriaPaper extends Model
{
    protected $table = 'criteria_paper';
    protected $fillable = ['criteria_id', 'paper_id', 'value'];
    public $timestamps = false;
}
