<?php
/**
 * Created by PhpStorm.
 * User: Tihomir
 * Date: 6.5.2016 г.
 * Time: 15:35
 */

namespace app\Classes;


class CriteriaType
{
    private $types = [
        1 => [
            'id' => 1,
            'title' => 'Text',
            'function' => 'buildText',
            'option' => false
        ],
        2 => [
            'id' => 2,
            'title' => 'Checkbox',
            'function' => 'buildCheckbox',
            'option' => false
        ],
        3 => [
            'id' => 3,
            'title' => 'Option',
            'function' => 'buildOption',
            'option' => true
        ]
    ];

    public function getTypes()
    {
        $types = [];
        foreach ($this->types as $type) {
            $types[$type['id']] = $type['title'];
        }
        return ['' => trans('static.select')] + $types;
    }

    public function getType($id)
    {
        return $this->types[$id];
    }
}