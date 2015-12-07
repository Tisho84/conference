<?php
/*
 * function that get database current language and return id
 */
function dbTrans($lang = null) {
    $locales = Config::get('app.locales');
    $lang = $lang ? : LaravelLocalization::setLocale() ? : app()->config->get('app.fallback_locale');
    if ($locales[$lang]) {
        return $locales[$lang]['id'];
    }
}

/*
 * function that return url with lang prefix
 */
function getLangUrl($url = '') {
    $fullUrl = '/' . LaravelLocalization::setLocale();
    $fullUrl .= $url ? '/' . $url : '';
    return $fullUrl;
}