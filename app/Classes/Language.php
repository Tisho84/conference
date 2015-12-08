<?php
/**
 * Created by PhpStorm.
 * User: Tihomir
 * Date: 7.12.2015 г.
 * Time: 20:18
 */

namespace App\Classes;


use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Language
{
    protected function process($array)
    {
        $data = [];
        foreach ($array as $id => $name ) {
            $data[$id] = $name[$this->getLanguage()];
        }
        return $data;
    }


    public function getLanguageId()
    {
        return app()->config->get('app.locales')[LaravelLocalization::setLocale()]['id'];
    }

    public function getLanguage()
    {
        return LaravelLocalization::setLocale();
    }


}