<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'invoice',
    'name' => 'Выставление счета',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'invoice'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'language' => 'ru-RU',
    'components' => [
        'request' => [
            'cookieValidationKey' => 'pja8YeP_Tv8SXyeFmAR6FLsGvLEHIpG0',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
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
                '<module:[\w-]+>/<controller:[\w-]+>/<action:[\w-]+>/<id:\d+>' => '<module>/<controller>/<action>',
                '<module:[\w-]+>/<controller:[\w-]+>/<action:[\w-]+>/<uuid:[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}>' => '<module>/<controller>/<action>',
                '<module:[\w-]+>/<controller:[\w-]+>/<action:[\w-]+>' => '<module>/<controller>/<action>',

                '<controller:[\w-]+>/<action:[\w-]+>' => '/',
            ],
        ],
    ],
    'modules' => [
        'invoice' => [
            'class' => \app\modules\invoice\Module::class,
        ],

    ],
    'params' => $params,
];

/*if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}*/

return $config;
