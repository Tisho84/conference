<?php

namespace App;


class CategoryLang extends LanguageModel
{
    protected $table = 'category_lang';

    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}
