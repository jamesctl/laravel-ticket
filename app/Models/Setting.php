<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
class Setting extends Model
{
    protected $table = "settings";

    protected $fillable = [
        'setting_name',
        'setting_key',
        'setting_value',
    ];

    // private $__lang;

    // public function __construct()
    // {
        // $this->__lang = Session::get('locale', 'en');
    // }
    
    /**
     * @return [type]
     */
    public static function getAboutSetting() {
        $setting = static::where('setting_key', 'about-us')->first();
        if ($setting) {
            $setting->setting_value = json_decode($setting->setting_value);
        }
        return $setting;
    }

    /**
     * @return [type]
     */
    public static function getHomepageSetting() {
        $setting = static::where('setting_key', 'setting-homepage')->first();
        $setting->setting_value = json_decode($setting->setting_value);
        return $setting;
    }

    /**
     * @return [type]
     */
    public static function getSettingByKey($key = 'about-us') {
        $setting = static::where('setting_key', $key)->first();
        if ($setting) {
            $setting->setting_value = json_decode($setting->setting_value);
        }
        return $setting;
    }

    /**
     * @return [type]
     */
    public static function getSettingByKeyV2($key = 'about-us') {
        $setting = static::where('setting_key', $key)->first();
        if ($setting) {
            $currentLang = Session::get('localel');
            if (!$currentLang) {
                $currentLang = 'en';
            }
            $setting->setting_value = json_decode($setting->setting_value);
            $setting->content = $setting->setting_value->$currentLang ?? null;
        }

        return $setting;
    }


    /**
     * @return [type]
     */
    public static function isUseDefaultLogo() {
        $setting = static::where('setting_key', 'use_default_logo')->first();
        return $setting->setting_value;
    }

    /**
     * @return [type]
     */
    public static function getPrivacySetting() {
        $setting = static::where('setting_key', 'privacy-policy')->first();
        if ($setting) {
            $setting->setting_value = json_decode($setting->setting_value);
            $setting->content = $setting->setting_value->en ?? null;
        }
        return $setting;
    }

    /**
     * @return [type]
     */
    public static function getCookieSetting() {
        $setting = static::where('setting_key', 'setting-cookie')->first();
        if ($setting) {
            $setting->setting_value = json_decode($setting->setting_value);
            $setting->content = $setting->setting_value->en ?? null;
        }
        return $setting;
    }

    /**
     * @return [type]
     */
    public static function getTermSetting() {
        $data = static::where('setting_key', 'setting-term-of-use')->first();
        $data->setting_value = json_decode($data->setting_value);
        return $data;
    }

    /**
     * @return [type]
     */
    public static function getEmailSetting() {
        return static::select('setting_value')->where('setting_key', 'email_settings')->first();
    }

    /**
     * @return [type]
     */
    public static function getEmailAccountAdminSetting() {
        $data = static::select('setting_value')->where('setting_key', 'settings_email_account')->first();
        
        return json_decode($data->setting_value)->admin;
    }

    /**
     * @return [type]
     */
    public static function getEmailAccountSupportSetting() {
        $data = static::select('setting_value')->where('setting_key', 'settings_email_account')->first();
        
        return json_decode($data->setting_value)->support;
    }

    /**
     * @return [type]
     */
    public static function getEmailAccountPaymentSetting() {
        $data = static::select('setting_value')->where('setting_key', 'settings_email_account')->first();
        
        return json_decode($data->setting_value)->payment;
    }
    
    public static function getZoomSetting() {
        return static::firstOrCreate([
            'setting_key' => config('constants.setting.zoom.key')
        ], [
            'setting_name' => config('constants.setting.zoom.name'),
            'setting_value' => json_encode([
                'account_id' => '',
            'client_id' => '',
            'client_secret' => ''
            ])
        ]);
    }

}
?>