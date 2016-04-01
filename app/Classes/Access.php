<?php
/**
 * Created by PhpStorm.
 * User: Tihomir
 * Date: 7.12.2015 г.
 * Time: 20:09
 */

namespace App\Classes;

use App\Classes\Language;
use App\Interfaces\ILanguage;

class Access extends Language implements ILanguage
{
    private $types = [
        1 => [
            'en' => 'Upload papers',
            'bg' => 'Качване на доклади'
        ],
        2 => [
            'en' => 'Review articles',
            'bg' => 'Оценка на доклади',
        ],
        3 => [
            'en' => 'Send emails',
            'bg' => 'Изпращане имейли',
        ],
        4 => [
            'en' => 'Manage news',
            'bg' => 'Управление новини',
        ],
        9 => [
            'en' => 'Admin panel',
            'bg' => 'Админ панел',
        ],
        10 => [
            'en' => 'Admin department',
            'bg' => 'Админ катедра',
        ],
        100 => [
            'en' => 'System admin',
            'bg' => 'Системен админ'
        ]
    ];

    public function getAccess()
    {
        return $this->process($this->types);
    }

    public function getTitle($id)
    {
        return $this->getAccess()[$id];
    }
}