<?php
/**
 * Created by PhpStorm.
 * User: Tihomir
 * Date: 20.5.2016 г.
 * Time: 16:37
 */

namespace App\Classes;


use App\EmailTemplate;

class Settings
{
    private $data;
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
        5 => [
            'key' => 'email_add_paper',
            'langs' => [
                'bg' => 'Имейл темплейт за качване на доклад',
                'en' => 'Email template for add paper'
            ],
            'plain' => false,
            'data' => 'templates'
        ],
        6 => [
            'key' => 'email_reviewer_paper',
            'langs' => [
                'bg' => 'Имейл темплейт за назначаване на рецензент към доклад',
                'en' => 'Email template for setting reviewer to paper'
            ],
            'plain' => false,
            'data' => 'templates'
        ],
        7 => [
            'key' => 'email_finished_paper',
            'langs' => [
                'bg' => 'Имейл темплейт за завършен доклад',
                'en' => 'Email template for finished paper'
            ],
            'plain' => false,
            'data' => 'templates'
        ],
        8 => [
            'key' => 'email_password_reset',
            'langs' => [
                'bg' => 'Имейл темплейт за смяна парола',
                'en' => 'Email template for reset password'
            ],
            'plain' => false,
            'data' => 'templates'
        ],
        9 => [
            'key' => 'email_notification',
            'langs' => [
                'bg' => 'Имейл темплейт за информиране на потребител при промяна и качване на доклад',
                'en' => 'Email template for paper upload and change notification'
            ],
            'plain' => false,
            'data' => 'templates'
        ]
    ];

    public function getSettings($departments)
    {
        $settings = [];
        $language = new Language();
        foreach ($this->settings as &$setting) {
            $setting['title'] = $setting['langs'][$language->getLanguage()];
            if (isset($setting['data'])) {
                $setting['data'] = $this->$setting['data']($departments);
            }
            $settings[] = $setting;
        }
        return $settings;
    }

    public function templates($departments)
    {
        foreach ($departments as $department) {
            if (!isset($this->data['templates'][$department->id])) {
                $this->data['templates'][$department->id] = simpleSelect(EmailTemplate::where('system', 1)->where('department_id', $department->id)->get(), true);
            }
        }
        return $this->data['templates'];
    }
}