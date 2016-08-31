<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');
        
$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'ru',
    'modules' => [ 
        'gridview' => [ 
            'class' => '\kartik\grid\Module' 
        ],
    ],
    'components' => [
        'request' => [
            'enableCookieValidation' => false,
            'enableCsrfValidation' => false,
            //'cookieValidationKey' => 'fdasgsdfgSDFG4563457347656yGNhdghhjr5673456hhdgh',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'session' => [
            'class' => 'yii\web\Session',
            'name' => 'ql',
            'cookieParams' => [
                'path' => '/ql',
                'httpOnly' => true,
            ]
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'enableSession' => true,
            'identityCookie' => [
                'name' => '_identity', 
                'httpOnly' => true,
                'domain'=>'vs585.imb.ru',
                'path'=>'/ql'
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => true,
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
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
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class'=>'yii\gii\Module',
        'allowedIPs'=>['*'],
    ];
}

return $config;
