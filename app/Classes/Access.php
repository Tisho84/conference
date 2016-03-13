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

class Access
{
    private $types = [
        1 => [
            'id' => 1,
            'title' => 'Upload papers',
        ],
        2 => [
            'id' => 2,
            'title' => 'Review articles',
        ],
        3 => [
            'id' => 3,
            'title' => 'Send emails',
        ],
        4 => [
            'id' => 4,
            'title' => 'Manage news',
        ],
        9 => [
            'id' => 9,
            'title' => 'Admin panel',
        ],
        10 => [
            'id' => 10,
            'title' => 'Admin Department',
        ],
        100 => [
            'id' => 100,
            'title' => 'System Admin',
        ]
    ];

    public function getAccess()
    {
        return array_pluck($this->types, 'title', 'id');
    }

    public function get($id)
    {
        return $this->getAccess()[$id];
    }
}