<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'medical-form',
    'name' => 'Medical Form System',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'id-ID',
    'timeZone' => 'Asia/Jakarta',
    'defaultRoute' => 'site/index',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'medical-form-secret-key-123',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['site/login'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
                'login' => 'site/login',
                'logout' => 'site/logout',
                'registrasi' => 'registrasi/index',
                'registrasi/create' => 'registrasi/create',
                'registrasi/update/<id:\d+>' => 'registrasi/update',
                'registrasi/delete/<id:\d+>' => 'registrasi/delete',
                'registrasi/view/<id:\d+>' => 'registrasi/view',
                'registrasi/input-form/<id_registrasi:\d+>' => 'registrasi/input-form',
                'registrasi/edit-form/<id:\d+>' => 'registrasi/edit-form',
                'registrasi/view-form/<id:\d+>' => 'registrasi/view-form',
                'registrasi/print-form/<id:\d+>' => 'registrasi/print-form',
                'registrasi/delete-form/<id:\d+>' => 'registrasi/delete-form',
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
