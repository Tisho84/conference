<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsLang extends ConferenceBaseModel
{
    protected $table = 'news_lang';
    protected $fillable = ['lang_id', 'title', 'description'];
    public $timestamps = false;

    public function news()
    {
        return $this->belongsTo('App\News');
    }
}
