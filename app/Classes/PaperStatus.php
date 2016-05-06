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

class PaperStatus extends Language implements ILanguage
{
    private $status = [
        1 => [
            'en' => 'Editable',
            'bg' => 'Отключен'
        ],
//        2 => [
//            'en' => 'Confirmed',
//            'bg' => 'Подтвърден',
//        ],
        2 => [
            'en' => 'Locked',
            'bg' => 'Заключен',
        ],
        3 => [
            'en' => 'Is estimated',
            'bg' => 'Оценява се',
        ],
        4 => [
            'en' => 'Finished',
            'bg' => 'Завършен',
        ]
    ];

    public function getStatuses()
    {
        return $this->process($this->status);
    }

    public function getTitle($id)
    {
        return $this->getStatuses()[$id];
    }


}