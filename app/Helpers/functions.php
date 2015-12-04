<?php
/*
 * function that get database current language and return id
 */
function dbTrans() {
    $locales = Config::get('app.locales');
    if ($locales[LaravelLocalization::setLocale()]) {
        return $locales[LaravelLocalization::setLocale()]['id'];
    }
}