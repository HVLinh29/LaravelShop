<?php

return [

    

    'driver' => env('MAIL_DRIVER', 'smtp'),

    'stream' => [
        'ssl' => [
            'allow_self_signed' => true,
            'verify_peer' => false,
            'verify_peer_name' => false,
        ],
        ],

    

        'host' => env('MAIL_HOST', 'smtp.googlemail.com'),

    

    'port' => env('MAIL_PORT', 465),

    

    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'linhmui199@gmail.com'),
        'name' => env('MAIL_FROM_NAME', 'VLinh 10C8'),
    ],

   

    'encryption' => env('MAIL_ENCRYPTION', 'ssl'),

   

    'username' => env('MAIL_USERNAME'),

    'password' => env('MAIL_PASSWORD'),

   

    'sendmail' => '/usr/sbin/sendmail -bs',

    

    'markdown' => [
        'theme' => 'default',

        'paths' => [
            resource_path('views/vendor/mail'),
        ],
    ],

    

    'log_channel' => env('MAIL_LOG_CHANNEL'),

];
