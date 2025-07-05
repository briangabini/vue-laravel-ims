<?php

use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;
use Monolog\Processor\PsrLogMessageProcessor;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    */
    'default' => env('LOG_CHANNEL', 'stack'),

    /*
    |--------------------------------------------------------------------------
    | Deprecations Log Channel
    |--------------------------------------------------------------------------
    */
    'deprecations' => [
        'channel' => env('LOG_DEPRECATIONS_CHANNEL', 'null'),
        'trace'   => env('LOG_DEPRECATIONS_TRACE', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    */
    'channels' => [

        // Aggregate *all* levels into one default stream
        'stack' => [
            'driver'           => 'stack',
            'channels'         => [
                'debug', 'info', 'notice',
                'warning', 'error', 'critical',
                'alert', 'emergency',
            ],
            'ignore_exceptions' => false,
        ],

        // Catch-all (if you still want a fall-back file)
        'single' => [
            'driver'     => 'single',
            'path'       => storage_path('logs/laravel.log'),
            'level'      => env('LOG_LEVEL', 'debug'),
            'replace_placeholders' => true,
        ],

        // One file per level:
        'debug' => [
            'driver'     => 'single',
            'path'       => storage_path('logs/debug.log'),
            'level'      => 'debug',
            'replace_placeholders' => true,
        ],

        'info' => [
            'driver'     => 'single',
            'path'       => storage_path('logs/info.log'),
            'level'      => 'info',
            'replace_placeholders' => true,
        ],

        'notice' => [
            'driver'     => 'single',
            'path'       => storage_path('logs/notice.log'),
            'level'      => 'notice',
            'replace_placeholders' => true,
        ],

        'warning' => [
            'driver'     => 'single',
            'path'       => storage_path('logs/warning.log'),
            'level'      => 'warning',
            'replace_placeholders' => true,
        ],

        'error' => [
            'driver'     => 'single',
            'path'       => storage_path('logs/error.log'),
            'level'      => 'error',
            'replace_placeholders' => true,
        ],

        'critical' => [
            'driver'     => 'single',
            'path'       => storage_path('logs/critical.log'),
            'level'      => 'critical',
            'replace_placeholders' => true,
        ],

        'alert' => [
            'driver'     => 'single',
            'path'       => storage_path('logs/alert.log'),
            'level'      => 'alert',
            'replace_placeholders' => true,
        ],

        'emergency' => [
            'path' => storage_path('logs/laravel.log'),
        ],

        'security' => [
            'driver' => 'single',
            'path' => storage_path('logs/security.log'),
            'level' => env('LOG_LEVEL', 'info'),
        ],

    ],

];
