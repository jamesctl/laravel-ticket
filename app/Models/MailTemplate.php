<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailTemplate extends Model
{
    protected $fillable = [
        'title',
        'content',
        'locale',
        'mail_key',
    ];

    protected $table = "mail_template";

    static public function getMailTemplate(string $mailKey = '')
    {
        return self::select('title', 'content')
            ->where('mail_key', '=', $mailKey)
            ->where('locale', '=', app()->getLocale())
            ->first()->toArray();
        ;
    }

}

?>