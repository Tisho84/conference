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

class AccessType extends Language implements ILanguage
{
    private $types = [
        1 => [
            'bg' => 'Качване на доклади',
            'en' => 'Upload papers'
        ],
        2 => [
            'bg' => 'Оценка на доклади',
            'en' => 'Review articles'
        ],
        3 => [
            'bg' => 'Изпращане на имейли',
            'en' => 'Send emails'
        ],
        10 => [
            'bg' => 'Администратор катедра',
            'en' => 'Administrator department'
        ],
        100 => [
            'bg' => 'Администратор система',
            'en' => 'Administrator система'
        ],
    ];

    public function getTypes()
    {
        return $this->process($this->types);
    }

    public function getTitle($id)
    {
        return $this->getTypes()[$id];
    }
}