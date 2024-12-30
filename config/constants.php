<?php

define('LANGUAGE',config('app.locale'));

return [
    'mail_env' => [
        'driver'       => 'smtp',
        'host'         => 'smtp.migadu.com',
        'port'         => '465',
        'username'     => 'test-ticket@centrala.vn',
        'password'     => '112233$$',
        'encryption'   => 'ssl',
        'from_address' => 'noreply@example.com',
        'from_name'    => 'Laravel',
        'sendmail'     => '/usr/sbin/sendmail -bs',
        'pretend'      => false,

    ],
    'setting' => [
        'about-us' => [
            'key'     => 'about-us',
            'name'    => 'About Us',
        ],
        'privacy' => [
            'key'     => 'privacy-policy',
            'name'    => 'Privacy Policy',
        ],
        'term' => [
            'key'     => 'terms-and-conditions',
            'name'    => 'Terms and conditions',
        ],
        'email-template' => [
            'key'     => 'email-template-list',
            'name'    => 'List Email Template',
        ],
        'zoom' => [
            'key' => 'zoom-credentials',
            'name' => 'Zoom credentials'
        ]
    ],
    'mail_account' => [
        'admin' => 'admin@lovely-talks.com',
        'support' => 'support@lovely-talks.com',
        'payment' => 'payment@lovely-talks.com'
    ],
    'locale' => [
        'english' => [
            'name' => 'English',
            'value' => 'en'
        ],
        'japan' => [
            'name' => 'Japanese',
            'value' => 'ja'
        ]
    ],
    'database' => [
        'status' => [
            'active' => [
                'name' => 'Active',
                'value' => 'active'
            ],
            'inactive' => [
                'name' => 'InActive',
                'value' => 'inactive'
            ]
        ]
    ],
    'logo' => '/assets/logo/version-2/lovely-talk-4.png',
    'logo_png' => '/assets/logo/version-2/lovely-talk-4-remove-background.png',
    'logo_svg' => '/assets/logo/version-2/lovely-talk-4-remove-background-svg.svg',
    'pagination' => 20,

    'new_logo_folder_upload' => public_path() . '/uploads_logo',
];
