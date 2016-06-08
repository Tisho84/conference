<?php
namespace App\Classes;

use App\Classes\Language;
use App\Interfaces\ILanguage;

class Access extends Language implements ILanguage
{
    private $types = [
        1 => [
            'en' => 'Upload / Edit papers',
            'bg' => 'Качване / Редакция на доклади'
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
        5 => [
            'en' => 'Manage users',
            'bg' => 'Управление потребители',
        ],
        6 => [
            'en' => 'Manage criteria',
            'bg' => 'Управление критерии',
        ],
        7 => [
            'en' => 'Manage categories',
            'bg' => 'Управление научни интереси',
        ],
        8 => [
            'en' => 'Manage settings',
            'bg' => 'Управление настройки',
        ],
        11 => [
            'en' => 'Manage archive',
            'bg' => 'Управление архив',
        ],
        12 => [
            'en' => 'Email notifications',
            'bg' => 'Имейл известия',
        ],
        13 => [
            'en' => 'Reviewer requests',
            'bg' => 'Заявки за рецензент',
        ],

        9 => [
            'en' => 'Admin panel',
            'bg' => 'Админ панел',
        ],
        10 => [
            'en' => 'Department',
            'bg' => 'Катедра',
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