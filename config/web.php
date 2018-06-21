<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'name' => 'News',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        'app\config\SetUp',
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@core'  => '@app/core',
        '@photoRoot' => $params['photoPath'],
        '@host'   => $params['HostInfo'],
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'hi6hdcRdFQCUpjxIZV870GQxktaFsn3g',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'core\entities\User',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_identity',
                'httpOnly' => true,
            ],
            'loginUrl' => ['auth/login'],
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
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'itemTable' => '{{%auth_items}}',
            'itemChildTable' => '{{%auth_item_children}}',
            'assignmentTable' => '{{%auth_assignments}}',
            'ruleTable' => '{{%auth_rules}}',
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'signup' => 'signup/request',
                'manager/<_c:[\w\-]+>' => 'manager/<_c>/index',
                'manager/<_c:[\w\-]+>/<id:\d+>' => 'manager/<_c>/view',
                'manager/<_c:[\w\-]+>/<_a:[\w-]+>' => 'manager/<_c>/<_a>',
                'manager/<_c:[\w\-]+>/<id:\d+>/<_a:[\w\-]+>' => 'manager/<_c>/<_a>',

                'cabinet' => 'cabinet/default/index',
                'cabinet/<_c:[\w\-]+>' => 'cabinet/<_c>/index',
                'cabinet/<_c:[\w\-]+>/<id:\d+>' => 'cabinet/<_c>/view',
                'cabinet/<_c:[\w\-]+>/<_a:[\w-]+>' => 'cabinet/<_c>/<_a>',
                'cabinet/<_c:[\w\-]+>/<id:\d+>/<_a:[\w\-]+>' => 'cabinet/<_c>/<_a>',
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '*'],
    ];
}

return $config;
