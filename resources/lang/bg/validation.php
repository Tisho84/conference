<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attribute трябва да бъде приет.',
    'active_url'           => ':attribute не е валидно URL.',
    'after'                => ':attribute трябва да бъде дата след :date.',
    'alpha'                => ':attribute може да съдържа само символи.',
    'alpha_dash'           => ':attribute може да съдържа символи, числа и тирета.',
    'alpha_num'            => ':attribute може да съдържа символи и числа .',
    'array'                => ':attribute трябва да бъде масив.',
    'before'               => ':attribute трябва да бъде дата преди :date.',
    'between'              => [
        'numeric' => ':attribute трябва да бъде между :min и :max.',
        'file'    => ':attribute трябва да бъде между :min и :max kilobytes.',
        'string'  => ':attribute трябва да бъде между :min и :max символа.',
        'array'   => ':attribute трябва да съдържа межу :min и :max елемента.',
    ],
    'boolean'              => 'Полето за :attribute трябва да бъде да или не.',
    'confirmed'            => 'Полето за :attribute потвърждаване не съвпада.',
    'date'                 => 'Полето за :attribute не е валидна дата.',
    'date_format'          => 'Полето за :attribute не съвпада с формата:format.',
    'different'            => 'Полето за :attribute и :other трябва да са различни.',
    'digits'               => 'Полето за :attribute трябва да се състои от :digits числа.',
    'digits_between'       => 'Полето за :attribute трябва да бъде между :min и :max числа.',
    'email'                => 'Полето за :attribute е невалидно.',
    'exists'               => 'Избрания :attribute е грешен.',
    'filled'               => 'Полето :attribute е задължително.',
    'image'                => ':attribute трябва да е снимка.',
    'in'                   => 'Полето :attribute е грешно.',
    'integer'              => ':attribute трябва да е число.',
    'ip'                   => ':attribute трявба да е валиден IP адрес.',
    'json'                 => ':attribute трябва да е валиден JSON формат.',
    'max'                  => [
        'numeric' => ':attribute не може да бъде повече от :max.',
        'file'    => ':attribute не може да бъде повече от  :max kilobytes.',
        'string'  => ':attribute не може да бъде повече от  :max символа.',
        'array'   => ':attribute не може да съдържа повече от :max елемента.',
    ],
    'mimes'                => ':attribute трябва да бъде файл от тип: :values.',
    'min'                  => [
        'numeric' => 'Полето :attribute трябва да бъде поне :min.',
        'file'    => 'Полето :attribute трябва да бъде поне :min kilobytes.',
        'string'  => 'Полето :attribute трябва да бъде поне :min символа.',
        'array'   => 'Полето :attribute трябва да съдържа поне :min елемента.',
    ],
    'not_in'               => 'Избрания :attribute е грешен.',
    'numeric'              => 'Полето :attribute трябва да е число.',
    'regex'                => 'Формата на :attribute е грешен.',
    'required'             => 'Полето за :attribute е задължително.',
    'required_if'          => 'Полето за :attribute е задължително, когато :other е :value.',
    'required_with'        => 'Полето за :attribute е задължително, когато :values са налични.',
    'required_with_all'    => 'Полето за :attribute е задължително, когато :values е наличен.',
    'required_without'     => 'Полето за :attribute е задължително, когато :values не са налични.',
    'required_without_all' => 'Полето за :attribute е задължително, когато нито една от :values е наличена.',
    'same'                 => 'Полето за :attribute и :other трябва да съвпадат.',
    'size'                 => [
        'numeric' => ':attribute трябва да е с размер :size.',
        'file'    => ':attribute трябва да е с размер :size kilobytes.',
        'string'  => ':attribute трябва да е с размер :size символа.',
        'array'   => ':attribute трябва да съдържа точно :size елемента.',
    ],
    'string'               => 'Полето за :attribute трябва да е символен низ.',
    'timezone'             => 'Полето за :attribute трябва да е валидна времева зона.',
    'unique'               => 'Полето за :attribute е вече заето.',
    'url'                  => ':attribute формата е грешен.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
