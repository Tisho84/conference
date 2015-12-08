<?php
/**
 * Created by PhpStorm.
 * User: Tihomir
 * Date: 7.12.2015 г.
 * Time: 20:55
 */

namespace App\Classes;

use App\Classes\Language;
use App\Interfaces\ILanguage;

class Rank extends Language implements ILanguage
{
    private $ranks = [
        0 => [
            'en' => 'Choose',
            'bg' => 'Избери'
        ],
        1 => [
            'en' => 'Bachelor',
            'bg' => 'Бакалавър'
        ],
        2 => [
            'en' => 'Master',
            'bg' => 'Магистър'
        ],
        3 => [
            'en' => 'Ph.D. Student',
            'bg' => 'Докторант'
        ],
        4 => [
            'en' => 'Ph.D',
            'bg' => 'Д-р'
        ],
        5 => [
            'en' => 'Assoc. Prof.',
            'bg' => 'Доц.'
        ],
        6 => [
            'en' => 'Prof',
            'bg' => 'Проф.'
        ],
    ];

    public function getRanks()
    {
        return $this->process($this->ranks);
    }

    public function getTitle($id)
    {
        return $this->getRanks()[$id];
    }
}