<?php

use App\Utils\Env;

return [
    'db' => [
        'host'     => Env::get('DB_HOST', 'localhost'),
        'name'     => Env::get('DB_NAME', 'login_register_db'),
        'user'     => Env::get('DB_USER', 'root'),
        'pass'     => Env::get('DB_PASS', ''),
        'charset'  => Env::get('DB_CHARSET', 'utf8mb4'),
    ],
    
    'mail' => [
        'host'       => Env::get('MAIL_HOST'),
        'port'       => Env::get('MAIL_PORT'),
        'username'   => Env::get('MAIL_USERNAME'),
        'password'   => Env::get('MAIL_PASSWORD'),
        'encryption' => Env::get('MAIL_ENCRYPTION'),
        'from'       => Env::get('MAIL_FROM'),
        'from_name'  => Env::get('MAIL_FROM_NAME'),
    ],
    
    'app' => [
        'url'             => Env::get('APP_URL', 'http://login-register.local'),
        'max_upload_mb'   => Env::get('MAX_UPLOAD_MB', 100),
        'session_timeout' => Env::get('SESSION_TIMEOUT', 900),
    ],
];

