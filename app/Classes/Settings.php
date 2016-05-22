<?php
/**
 * Created by PhpStorm.
 * User: Tihomir
 * Date: 20.5.2016 г.
 * Time: 16:37
 */

namespace App\Classes;


class Settings
{
    private $settings = [
        1 => [
            'key' => 'registrations',
            'langs' => [
                'en' => 'Lock new registrations',
                'bg' => 'Заключване на нови регистрации'
            ],
            'plain' => false
        ],
        2 => [
            'key' => 'papers',
            'langs' => [
                'en' => 'Lock(add/edit) papers',
                'bg' => 'Заключване(добавяне/редакция) на доклади'
            ],
            'plain' => false
        ],
        3 => [
            'key' => 'user_data',
            'langs' => [
                'en' => 'Lock editing user data',
                'bg' => 'Забрана за промяна потребителска информация'
            ],
            'plain' => false
        ],
        4 => [
            'key' => 'news_pages',
            'langs' => [
                'en' => 'Number news per page',
                'bg' => 'Брой новини на страница'
            ],
            'plain' => true
        ],
    ];

    public function getSettings()
    {
        $settings = [];
        $language = new Language();
        foreach ($this->settings as &$setting) {
            $setting['title'] = $setting['langs'][$language->getLanguage()];
            $settings[] = $setting;
        }
        return $settings;
    }
}