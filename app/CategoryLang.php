<?php

namespace App;

use App\Interfaces\ILanguageModel;

class CategoryLang extends BaseModel implements  ILanguageModel
{
    protected $table = 'category_lang';

    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}
