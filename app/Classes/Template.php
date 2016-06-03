<?php
/**
 * Created by PhpStorm.
 * User: Tihomir
 * Date: 29.5.2016 г.
 * Time: 18:24
 */

namespace App\Classes;


class Template
{
    private $templates = [
        1 => [
            'langs' => [
                'en' => 'Upload paper',
                'bg' => 'Качване доклад'
            ],
            'params' => [
                '[name]', '[time]', '[link]'
            ]
        ],
        2 => [
            'langs' => [
                'en' => 'Paper change',
                'bg' => 'Промяна доклад'
            ],
            'params' => [
                '[name]', '[time]', '[link]'
            ]
        ],
        3 => [
            'langs' => [
                'en' => 'Reviewer set to paper',
                'bg' => 'Назначаване на рецензент към доклад',
            ],
            'params' => [
                '[name]', '[link]'
            ]
        ],
        4 => [
            'langs' => [
                'en' => 'Paper finished',
                'bg' => 'Завършен доклад',
            ],
            'params' => [
                '[name]', '[time]', '[link]'
            ]
        ],
        5 => [
            'langs' => [
                'en' => 'Password reset',
                'bg' => 'Смяна парола',
            ],
            'params' => [
                '[name]', '[expire]', '[link]'
            ]
        ],
        6 => [
            'langs' => [
                'en' => 'Paper upload and change notification',
                'bg' => 'Информиране на потребител при промяна и качване на доклад',
            ],
            'params' => [
                '[author_name]', '[admin_name]', '[time]', '[link]', '[operation]',
            ]
        ],
    ];


    public function getParams()
    {
        $text = '';
        $language = new Language();
        $language = $language->getLanguage();
        foreach ($this->templates as $template) {
            $text .= $template['langs'][$language] . ' - ' . implode(', ', $template['params']) . '</br>';
        }

        return $text;
    }

    public function parser($text, $data)
    {
        $params = [];
        foreach ($this->templates as $template) {
            $params = array_merge($template['params'], $params);
        }

        foreach ($params as $param) {
            if (strpos($text, $param)) {
                $tmpParam = rtrim(ltrim($param, '['), ']');
                $text = str_replace($param, isset($data[$tmpParam]) ? $data[$tmpParam] : $tmpParam, $text);
            }
        }

        return $text;
    }
}