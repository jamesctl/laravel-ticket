<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class MailConfigServiceProvider extends ServiceProvider {
    /**
     * Register services.
     *
     * @return void
     */
    public function register() {
        if (Schema::hasTable('settings')) {
            $settings = DB::table('settings')->where(['setting_key' => 'email_settings'])->first();
            if ($settings !== null) {
                $mail = json_decode($settings->setting_value);    
                if ($mail)
                {
                    $config = [
                        'driver'     => $mail->driver,
                        'host'       => $mail->host,
                        'port'       => $mail->port,
                        'from'       => ['address' => $mail->from_address, 'name' => $mail->from_name],
                        'encryption' => $mail->encryption,
                        'username'   => $mail->username,
                        'password'   => $mail->password,
                        'sendmail'   => $mail->sendmail,
                        'pretend'    => config('constants.mail_env.pretend')
                    ];
                    Config::set('mail', $config);
                }
            }
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() {

        app()->bind('emailSetting', function() {
            return Setting::firstOrCreate(['setting_key' => 'email_settings'], [
                'setting_value' => json_encode(config('constants.mail_env')),
                'setting_name' => 'Email Setting'
            ]);
        });

    }
}
