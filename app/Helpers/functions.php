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
     * #accepts id and return short
     */
    function systemTrans($id) {
        $locales = Config::get('app.locales');
        $abbr = '';
        foreach ($locales as $short => $locale) {
            if ($locale['id'] == $id) {
                $abbr = $short;
                break;
            }
        }
        return $abbr;
    }
    /*
     * function that return url with lang prefix
     */
    function getLangUrl($url = '') {
        $fullUrl = '/' . LaravelLocalization::setLocale();
        $fullUrl .= $url ? '/' . $url : '';
        return $fullUrl;
    }

    /*
     * function that builds nomenclature for select
     */
    function getNomenclatureSelect($collection, $first = false) {
        $array = [];
        foreach ($collection as $element) {
            $array[$element['id']] = $element->langs->first()->name;;
        }

        if ($first) {
            $array = ['' => trans('static.select')] + $array;
        }

        return $array;
    }

    function simpleSelect($collection, $first = false, $key = 'name') {
        $array = [];
        foreach ($collection as $element) {
            $array[$element->id] = $element->$key;
        }

        if ($first) {
            $array = ['' => trans('static.select')] + $array;
        }

        return $array;
    }

    /*
     * function that build table headers based on languages
     */

    function buildTh($title = '') {
        $html = '';
        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
            $html .= '<th>' . $properties['native'] . ' ' . $title . '</th>';
        }
        return $html;
    }

    /*
     * function that build active select
     */
    function buildActive() {
        $html = '';
        $html .= '<label for="active">' . trans('admin.active') . '</label>';
        $html .= Form::select('active', selectBoolean(), null, ['class' => 'form-control select2-simple', 'style' => 'width: 100%;']);
        return $html;
    }

    function calcSort($sort) {
        return $sort + (100 - ($sort % 100));
    }

    /*
     * function that check user access type
     */
    function systemAccess($access, $user = null) {
        $user = $user ? : \Illuminate\Support\Facades\Auth::user();
        if (
            !$user ||
            !$user->user_type_id ||
            !in_array($access, $user->type->access->pluck('access_id')->toArray())
        ) { #has not access
            return false;
        }
        return true;
    }

    function isAdminPanel() {
        return request()->segment(2) == 'admin' ? true : false;
    }

    function boolString($int) {
        if ($int) {
            return trans('static.yes');
        }
        return trans('static.no');
    }

    function selectBoolean() {
        return [ 1 => trans('static.yes'), 0 => trans('static.no')];
    }

    function buildPaperLink(App\Paper $paper) {
        return action('PaperController@show', [$paper->department->keyword, $paper->id]);
    }

    /*
     * setActive for active link
     */
    function setActive($path) {
        $prefix = LaravelLocalization::setLocale() . '/' . request()->segment(2);
        if (request()->is($prefix . $path) || request()->is($prefix . $path . '/*')) {
            return "class=active";
        }
        return '';
    }