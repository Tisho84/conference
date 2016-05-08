<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CriteriaOptionLang extends Model
{
    protected $table = 'criteria_option_lang';
    protected $fillable = ['lang_id', 'title'];
    public $timestamps = false;

    public function option()
    {
        return $this->belongsTo('App\CriteriaOption', 'option_id');
    }
}
