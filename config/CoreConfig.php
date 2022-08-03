<?php

namespace app\config;

use app\model\User;

class CoreConfig
{
    public static function config():array
    {
        return [
            'userClass' => User::class,
            'db' => [
                'dsn' => $_ENV['DB_DSN'],
                'user' => $_ENV['DB_USER'],
                'password' => $_ENV['DB_PASSWORD']
            ]
        ];
    }
}