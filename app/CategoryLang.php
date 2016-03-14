<?php

namespace App;

class CategoryLang extends LanguageModel
{
    protected $table = 'category_lang';
    protected $fillable = ['lang_id', 'name'];
    public $timestamps = false;

    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}
