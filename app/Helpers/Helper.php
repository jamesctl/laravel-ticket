<?php

use App\Library\Common;
use App\Models\TranslatorTranslations;
use App\Models\UserPermission;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use App\Services\Base;

if (!function_exists('isNavActive')) {
    function isNavActive(String $routeName)
    {
        return Route::currentRouteName() === $routeName;
        // return Route::currentRouteName() && strpos(Route::currentRouteName(), $routeName) === 0;

        // if (strpos(Route::currentRouteName(), $routeName) === 0) return true;
        // return strpos(Request::url(), $routeName) === 0;
    }
}

function setToDefaultTimezone($time) {
    $value = carbon($time)->shiftTimezone(date_default_timezone_get())->setTimezone(config('app.timezone'));
    return $value;
}

function getAllCountries() {
    return Cache::remember('countries', null, function() {
        $client = new Client();
        $response = $client->get('https://restcountries.com/v3.1/all?fields=name');
        return json_decode((string) $response->getBody());
    });
}

function convertToCurrentTimezone($time) {
    return carbon($time)->shiftTimezone(config('app.timezone'))->setTimezone(date_default_timezone_get());
}
function getCurrentTimezone() {
    $common = new Common;
    if (request()->user()) {
        return request()->user()->timezone_name;
    }
    $ip = request()->ip();
    return $common->getTimeZoneByIp($ip);
}
function carbon($time = null) {
    return new Carbon($time);
}
function formatTimestampToDateTime($timestamp) {
    if (!$timestamp) {
        return null;
    }
    return Carbon::createFromTimestamp($timestamp)
        ->toDateTimeString();
}
function getNextMonth($date = null)
{
    $strDate = !empty($date) ? $date : Carbon::now();
    $nextMonth = carbon($strDate)->addMonth();
    return $nextMonth->toDateTimeString();
}

function format_currency($value) {
    return number_format($value);
}

function format_currency_with_label($value, $currency = 'usd') {
    return getCurrencySymbol($currency) . format_currency($value);
}
function getCurrencySymbol($code) {
    return getCurrencyArray()[strtoupper($code)];
}
function getCurrencyArray() {
    return [
        'AED' => 'د.إ',
        'AFN' => 'Af',
        'ALL' => 'Lek',
        'AMD' => 'դ',
        'ANG' => 'ƒ',
        'AOA' => 'Kz',
        'ARS' => '$',
        'AUD' => '$',
        'AWG' => 'ƒ',
        'AZN' => '₼',
        'BAM' => 'KM',
        'BBD' => '$',
        'BDT' => '৳',
        'BGN' => 'лв',
        'BHD' => '.د.ب',
        'BIF' => 'FBu',
        'BMD' => '$',
        'BND' => '$',
        'BOB' => '$b',
        'BRL' => 'R$',
        'BSD' => '$',
        'BTN' => 'Nu.',
        'BWP' => 'P',
        'BYR' => 'p.',
        'BZD' => 'BZ$',
        'CAD' => '$',
        'CDF' => 'FC',
        'CHF' => 'CHF',
        'CLF' => 'UF',
        'CLP' => '$',
        'CNY' => '¥',
        'COP' => '$',
        'CRC' => '₡',
        'CUP' => '⃌',
        'CVE' => '$',
        'CZK' => 'Kč',
        'DJF' => 'Fdj',
        'DKK' => 'kr',
        'DOP' => 'RD$',
        'DZD' => 'دج',
        'EGP' => 'E£',
        'ETB' => 'Br',
        'EUR' => '€',
        'FJD' => '$',
        'FKP' => '£',
        'GBP' => '£',
        'GEL' => 'ლ',
        'GHS' => '¢',
        'GIP' => '£',
        'GMD' => 'D',
        'GNF' => 'FG',
        'GTQ' => 'Q',
        'GYD' => '$',
        'HKD' => '$',
        'HNL' => 'L',
        'HRK' => 'kn',
        'HTG' => 'G',
        'HUF' => 'Ft',
        'IDR' => 'Rp',
        'ILS' => '₪',
        'INR' => '₹',
        'IQD' => 'ع.د',
        'IRR' => '﷼',
        'ISK' => 'kr',
        'JEP' => '£',
        'JMD' => 'J$',
        'JOD' => 'JD',
        'JPY' => '¥',
        'KES' => 'KSh',
        'KGS' => 'лв',
        'KHR' => '៛',
        'KMF' => 'CF',
        'KPW' => '₩',
        'KRW' => '₩',
        'KWD' => 'د.ك',
        'KYD' => '$',
        'KZT' => '₸',
        'LAK' => '₭',
        'LBP' => '£',
        'LKR' => '₨',
        'LRD' => '$',
        'LSL' => 'L',
        'LTL' => 'Lt',
        'LVL' => 'Ls',
        'LYD' => 'ل.د',
        'MAD' => 'د.م.',
        'MDL' => 'L',
        'MGA' => 'Ar',
        'MKD' => 'ден',
        'MMK' => 'K',
        'MNT' => '₮',
        'MOP' => 'MOP$',
        'MRO' => 'UM',
        'MUR' => '₨',
        'MVR' => '.ރ',
        'MWK' => 'MK',
        'MXN' => '$',
        'MYR' => 'RM',
        'MZN' => 'MT',
        'NAD' => '$',
        'NGN' => '₦',
        'NIO' => 'C$',
        'NOK' => 'kr',
        'NPR' => '₨',
        'NZD' => '$',
        'OMR' => '﷼',
        'PAB' => 'B/.',
        'PEN' => 'S/.',
        'PGK' => 'K',
        'PHP' => '₱',
        'PKR' => '₨',
        'PLN' => 'zł',
        'PYG' => 'Gs',
        'QAR' => '﷼',
        'RON' => 'lei',
        'RSD' => 'Дин.',
        'RUB' => '₽',
        'RWF' => 'ر.س',
        'SAR' => '﷼',
        'SBD' => '$',
        'SCR' => '₨',
        'SDG' => '£',
        'SEK' => 'kr',
        'SGD' => '$',
        'SHP' => '£',
        'SLL' => 'Le',
        'SOS' => 'S',
        'SRD' => '$',
        'STD' => 'Db',
        'SVC' => '$',
        'SYP' => '£',
        'SZL' => 'L',
        'THB' => '฿',
        'TJS' => 'TJS',
        'TMT' => 'm',
        'TND' => 'د.ت',
        'TOP' => 'T$',
        'TRY' => '₤',
        'TTD' => '$',
        'TWD' => 'NT$',
        'TZS' => 'TSh',
        'UAH' => '₴',
        'UGX' => 'USh',
        'USD' => '$',
        'UYU' => '$U',
        'UZS' => 'лв',
        'VEF' => 'Bs',
        'VND' => '₫',
        'VUV' => 'VT',
        'WST' => 'WS$',
        'XAF' => 'FCFA',
        'XCD' => '$',
        'XDR' => 'SDR',
        'XOF' => 'FCFA',
        'XPF' => 'F',
        'YER' => '﷼',
        'ZAR' => 'R',
        'ZMK' => 'ZK',
        'ZWL' => 'Z$',
    ];
}

function getPlanCurrencies() {
    return [
        'usd' => 'USD',
        'jpy' => 'Japanese Yen',
    ];
}
function getCountryCodeFromLocale($locale) {
    $countryCodes = [
        'af' => 'ZA', 'ak' => 'GH', 'am' => 'ET', 'ar' => 'SA', 'as' => 'IN', 'az' => 'AZ', 'be' => 'BY', 'bg' => 'BG', 'bm' => 'ML',
        'bn' => 'BD', 'bo' => 'CN', 'br' => 'FR', 'bs' => 'BA', 'ca' => 'ES', 'cs' => 'CZ', 'cy' => 'GB', 'da' => 'DK', 'de' => 'DE',
        'dz' => 'BT', 'ee' => 'GH', 'el' => 'GR', 'en' => 'US', 'eo' => 'XK', 'es' => 'ES', 'et' => 'EE', 'eu' => 'ES', 'fa' => 'IR',
        'ff' => 'SN', 'fi' => 'FI', 'fo' => 'FO', 'fr' => 'FR', 'fy' => 'NL', 'ga' => 'IE', 'gd' => 'GB', 'gl' => 'ES', 'gu' => 'IN',
        'gv' => 'GB', 'ha' => 'NG', 'he' => 'IL', 'hi' => 'IN', 'hr' => 'HR', 'ht' => 'HT', 'hu' => 'HU', 'hy' => 'AM', 'ia' => 'XK',
        'id' => 'ID', 'ig' => 'NG', 'ii' => 'CN', 'is' => 'IS', 'it' => 'IT', 'iu' => 'CA', 'ja' => 'JP', 'ka' => 'GE', 'ki' => 'KE',
        'kk' => 'KZ', 'kl' => 'GL', 'km' => 'KH', 'kn' => 'IN', 'ko' => 'KR', 'ks' => 'IN', 'kw' => 'GB', 'ky' => 'KG', 'lb' => 'LU',
        'lg' => 'UG', 'ln' => 'CG', 'lo' => 'LA', 'lt' => 'LT', 'lu' => 'CD', 'lv' => 'LV', 'mg' => 'MG', 'mk' => 'MK', 'ml' => 'IN',
        'mn' => 'MN', 'mr' => 'IN', 'ms' => 'MY', 'mt' => 'MT', 'nb' => 'NO', 'nd' => 'ZW', 'ne' => 'NP', 'nl' => 'NL', 'nn' => 'NO',
        'om' => 'ET', 'or' => 'IN', 'os' => 'RU', 'pa' => 'IN', 'pl' => 'PL', 'ps' => 'AF', 'pt' => 'PT', 'rm' => 'CH', 'rn' => 'BI',
        'ro' => 'RO', 'ru' => 'RU', 'rw' => 'RW', 'se' => 'NO', 'sg' => 'CF', 'si' => 'LK', 'sk' => 'SK', 'sl' => 'SI', 'sn' => 'ZW',
        'so' => 'SO', 'sq' => 'AL', 'sr' => 'RS', 'sv' => 'SE', 'sw' => 'TZ', 'ta' => 'IN', 'te' => 'IN', 'th' => 'TH', 'ti' => 'ER',
        'tk' => 'TM', 'tl' => 'PH', 'tn' => 'BW', 'to' => 'TO', 'tr' => 'TR', 'ts' => 'ZA', 'ug' => 'CN', 'uk' => 'UA', 'ur' => 'PK',
        'uz' => 'UZ', 'vi' => 'VN', 'wo' => 'SN', 'xh' => 'ZA', 'yo' => 'NG', 'zh' => 'CN', 'zu' => 'ZA',
    ];

    return isset($countryCodes[$locale]) ? $countryCodes[$locale] : null;
}
function getFlagByLocale($locale) {
    return asset("assets/flags/".strtolower(getCountryCodeFromLocale($locale)).".svg");
}

function setGlobalTimezone($timezone) {
    return date_default_timezone_set($timezone);
}

function getInfoLocale(string $arrData, $locale = 'en')
{
    try {
        if(!empty($arrData)) {
            $data = unserialize($arrData);
            return $data[$locale];
        }
    } catch(\Throwable $th) {
        \Log::error($th->getMessage());
        return null;
    }
}

function getValueDecode($str)
{
    try {
        return json_decode($str);
    } catch(\Throwable $th) {
        \Log::error($th->getMessage());
        return [];
    }

}

function getBadgeColorTopStudentCoin($index)
{
    $arrColors = ['#dfbb45', '#ff7474', '#eb7ccf', '#37b4d3'];
    return $arrColors[$index] ?? '#37b4d3';
}

function getListLanguage($setKey = true)
{
    $checkTable = Schema::hasTable('translator_languages');

    if (!$checkTable) {
        return [];
    }

    $translatorLanguage = new \App\Models\TranslatorLanguage();

    $list = $translatorLanguage->getAll();
//    set key là locale
    if ($setKey)
        $list = $list->keyBy('locale');

    return $list;
}

function handleTranslate($data,$request)
{
    $translation = new TranslatorTranslations();

    if (isset($data->title_translation)){
        $titleTrans = str_replace('translatable.','',$data->title_translation);
        $getTitleTrans = collect($translation->getItem(LANGUAGE,$titleTrans))->toArray();
    }


    if (isset($data->description_translation)){
        $descriptionTrans = str_replace('translatable.','',$data->description_translation);
        $getDescriptionTrans = collect($translation->getItem(LANGUAGE,$descriptionTrans))->toArray();

    }

    if (isset($data->short_description_translation)){
        $shortDescriptionTrans = str_replace('translatable.','',$data->short_description_translation);
        $getShortDescriptionTrans = collect($translation->getItem(LANGUAGE,$shortDescriptionTrans))->toArray();
    }

    if (isset($data->price_translation)){
        $priceTrans = str_replace('translatable.','',$data->price_translation);
        $getPriceTrans = collect($translation->getItem(LANGUAGE,$priceTrans))->toArray();
    }


    //        Xóa các config liên quan
    handleRemoveTranslate($data);

    $list = [];
    foreach (getListLanguage() as $key => $item){
        if (isset($getTitleTrans) && count($getTitleTrans) != 0) {
            $list[$key.'title'] = $getTitleTrans;
            $list[$key.'title']['locale'] = $key;
            $list[$key.'title']['text'] = $request->input('title-' . $key) !== null ? $request->input('title-'.$key) : '';
            $list[$key.'title']['locked'] = 1;
        }

        if ( isset($getDescriptionTrans) && count($getDescriptionTrans) != 0){
            $list[$key.'description'] = $getDescriptionTrans;
            $list[$key.'description']['locale'] = $key;
            $list[$key.'description']['text'] = $request->input('description-' . $key) !== null ? $request->input('description-'.$key) : '';
            $list[$key.'description']['locked'] = 1;
        }

        if ( isset($getShortDescriptionTrans) && count($getShortDescriptionTrans) != 0){
            $list[$key.'short_description'] = $getShortDescriptionTrans;
            $list[$key.'short_description']['locale'] = $key;
            $list[$key.'short_description']['text'] = $request->input('short_description-' . $key) !== null ? $request->input('short_description-'.$key) : '';
            $list[$key.'short_description']['locked'] = 1;
        }

        if ( isset($getPriceTrans) && count($getPriceTrans) != 0){
            $list[$key.'price'] = $getPriceTrans;
            $list[$key.'price']['locale'] = $key;
            $list[$key.'price']['text'] = $request->input('price-' . $key) !== null ? $request->input('price-'.$key) : '';
            $list[$key.'price']['locked'] = 1;
        }
    }

    if(count($list) != 0){
        $translation->insertData($list);
    }
    return true;
}

function handleRemoveTranslate($data)
{
    $translation = new TranslatorTranslations();
    $keyTitle = '';
    $keyDescription = '';
    $keyShortDescription = '';
    $keyPrice = '';

    if (isset($data['title_translation'])){
        $keyTitle = str_replace('translatable.','',$data['title_translation']);
    }

    if (isset($data['description_translation'])){
        $keyDescription = str_replace('translatable.','',$data['description_translation']);
    }

    if (isset($data['short_description_translation'])){
        $keyShortDescription = str_replace('translatable.','',$data['short_description_translation']);
    }

    if (isset($data['price_translation'])){
        $keyPrice = str_replace('translatable.','',$data['price_translation']);
    }

    $translation->removeTransDetail($keyTitle,$keyDescription,$keyShortDescription, $keyPrice);
    return true;
}

function checkPermission($routeName)
{
    $user = Auth::user();
    // if ($user->is_root == 'yes'){
    //     return true;
    // }
    $route = Route::getRoutes()->getByName($routeName);
    if ($route) {
        $middlewares = $route->getAction()['middleware'];
        $middlewares = collect($middlewares)->first(function ($item){
            if (strpos($item, 'permission:') !== false){
                return str_replace('permission:','',$item);
            }
        });
        if (isset($middlewares)){
            $middlewares = str_replace('permission:','',$middlewares);

            $userPermission = new UserPermission();

            $check = $userPermission->checkPagePermision($user->id,$middlewares);
            if($check == null){
                return false;
            }
            return true;
        }
    }

    return false;
}

function fillTranslateFe($item, $table, $columns) {
    $result = [];
    $currentLang = Session::get('localel');
    if (!$currentLang) {
        $currentLang = 'en';
    }

    foreach ($columns as $column) {
        $result[$column] = '';
        foreach ($item as $key => $value) {
            if (strpos($key, "$table.$column") !== false) {
                foreach ($value as $data) {
                    if ($data->locale == $currentLang) {
                        $result[$column] = $data->text;
                    }
                }
            }
        }
    }

    return $result;
}

function convertStringToSlug($string) {
    $replacement = '-';
        $map = array();
        $quotedReplacement = preg_quote($replacement, '/');
        $default = array(
            '/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ|À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ|å/' => 'a',
            '/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ|È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ|ë/' => 'e',
            '/ì|í|ị|ỉ|ĩ|Ì|Í|Ị|Ỉ|Ĩ|î/' => 'i',
            '/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ|Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ|ø/' => 'o',
            '/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ|Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ|ů|û/' => 'u',
            '/ỳ|ý|ỵ|ỷ|ỹ|Ỳ|Ý|Ỵ|Ỷ|Ỹ/' => 'y',
            '/đ|Đ/' => 'd',
            '/ç/' => 'c',
            '/ñ/' => 'n',
            '/ä|æ/' => 'ae',
            '/ö/' => 'oe',
            '/ü/' => 'ue',
            '/Ä/' => 'Ae',
            '/Ü/' => 'Ue',
            '/Ö/' => 'Oe',
            '/ß/' => 'ss',
            '/[^\s\p{Ll}\p{Lm}\p{Lo}\p{Lt}\p{Lu}\p{Nd}]/mu' => ' ',
            '/\\s+/' => $replacement,
            sprintf('/^[%s]+|[%s]+$/', $quotedReplacement, $quotedReplacement) => '',
        );
        //Some URL was encode, decode first
        $string = urldecode($string);
        $map = array_merge($map, $default);
        return strtolower(preg_replace(array_keys($map), array_values($map), $string));
}

if (!function_exists('get_icon_for_mime_type')) {
    /**
     * 
     *
     * @param string $mimeType
     * @return string
     */
    function get_icon_for_mime_type($mimeType)
    {
        $service = new Base();
        return $service->getIconForMimeType($mimeType);
    }
}

if (!function_exists('website_setting_upload_image')) {
    /**
     * 
     *
     * @param string $extension
     * @return string
     */
    function website_setting_upload_image($name, $request, &$validated, $setting_value)
    {
        if ($request->hasFile($name)) {
            $file = $request->file($name);
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads', $fileName, 'public');
            $validated[$name] = $filePath;
        } else {
            if (isset(json_decode($setting_value)->$name)) {
                $validated[$name] = json_decode($setting_value)->$name;
            }
        }
    }
}


if (!function_exists('getUserIP')) {
    /**
     * 
     *
     * @param string $extension
     * @return string
     */
    function getUserIP()
    {
        $ipaddress = '';
	if (getenv('HTTP_CLIENT_IP'))
		$ipaddress = getenv('HTTP_CLIENT_IP');
	else if(getenv('HTTP_X_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	else if(getenv('HTTP_X_FORWARDED'))
		$ipaddress = getenv('HTTP_X_FORWARDED');
	else if(getenv('HTTP_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_FORWARDED_FOR');
	else if(getenv('HTTP_FORWARDED'))
		$ipaddress = getenv('HTTP_FORWARDED');
	else if(getenv('REMOTE_ADDR'))
		$ipaddress = getenv('REMOTE_ADDR');
	else
		$ipaddress = 'UNKNOWN';

	return $ipaddress;
    }
}

if (!function_exists('changeDateFormat')) {
    /**
     * 
     *
     * @param string $extension
     * @return string
     */
    function changeDateFormat($lang, $date)
    {
        if ($lang == 'en') {
            return Carbon::parse($date)->format('d M Y');
        } elseif ($lang == 'ja') {
            return Carbon::parse($date)->format('Y年m月d日');
        } else {
            $date = Carbon::parse($date);
            return 'ngày ' . $date->format('d') . ' tháng ' . $date->format('m') . ' năm ' . $date->format('Y');
        }
    }
}

if (!function_exists('changeMinReadFormat')) {
    /**
     * 
     *
     * @param string $extension
     * @return string
     */
    function changeMinReadFormat($lang, $number)
    {
        if ($lang == 'en') {
            return $number . ' min read';
        } elseif ($lang == 'ja') {
            return $number . ' 分読み';
        } else {
            return $number . ' phút trước';
        }
    }
}