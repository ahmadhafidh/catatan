<?php
require(__DIR__.'/functions.php');
$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$domain = $_SERVER['HTTP_HOST'];
date_default_timezone_set('Asia/Jakarta');

$config = [
    'id' => 'basic',
    'name' => 'Catatan',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'layout' => 'main_layout',
    'timeZone' => 'Asia/Jakarta',
    'language' => 'id',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
            // enter optional module parameters below - only if you need to  
            // use your own export download action or custom translation 
            // message source
            // 'downloadAction' => 'gridview/export/download',
            // 'i18n' => []
        ],
        'admin' => [
            'class' => 'app\modules\admin\Module',
            'controllerMap' => [
                'assignment' => [
                    'class' => 'app\modules\admin\controllers\AssignmentController',
                    'userClassName' => 'app\models\Users',
                    // 'usernameField' => 'name',
                    // 'extraColumns'  => ['email', 'user_type']
                ],
            ],
        ],
        'api' => [
            'class' => 'app\modules\api\NotificationModule',
        ],
        'gii2' => [
            'class' => 'yii\gii\Module',
            'generators' => [
                'mongoDbModel' => [
                    'class' => 'yii\mongodb\gii\model\Generator'
                ]
            ],
        ],
    ],
    'components' => [
        'formatter' => [
            'currencyCode' => 'IDR',
            'decimalSeparator' => ',',
            'locale' => 'id',
            'thousandSeparator' => '.',
        ],
        'mongodb' => $db['log_mongo'],
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => [],
                    'depends' => ['app\assets\AppAsset']
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => []
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [],
                ],
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'lMgSx4yQz2Xw0_fNmetEkkHnccMeTVfy',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\Users',
            'enableAutoLogin' => false,
        ],
        'session' => [
            'class' => 'app\components\FTDbSession',
            'db' => $db['db'],
            'sessionTable' => 'web_session',
            'timeout' => 1800,
            'writeCallback' => function ($session) {
                return [
                    'user_id' => Yii::$app->user->id
                ];
            },
            'cookieParams' => [
                'domain' => $domain,
                'httpOnly' => true,
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'log_mongo'=> $db['log_mongo'],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => 'mail',
            'viewPath' => '@app/mail',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => '',
                'password' => '',
                'port' => '587',
                'encryption' => 'tls',
                'streamOptions' => [
                    'ssl' => [
                        'allow_self_signed' => true,
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                    ],
                ],
            ]
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\mongodb\log\MongoDbTarget',
                    'levels' => ['error','warning'],
                    'db' => $db['log_mongo'],
                    'logCollection' => 'yii_log'
                ],
            ],
        ],
        'db' => $db['db'],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => array(
                '<controller:[\w-]+>/<id:\d+>' => '<controller>/view',
                // '<controller:[\w-]+>/<action:[\w-]+>/<id:\d+>' => '<controller>/<action>',
                // '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => ['api/notification'],
                ],    
            ),
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\PhpManager'
        ],
    ],
    'params' => $params,
    'as access' => [
        'class' => 'app\components\rbac\AccessControl',
        'allowActions' => [
            'site/*',
            '*',
            
            // 'some-controller/some-action',
            // The actions listed here will be allowed to everyone including guests.
            // So, 'admin/*' should not appear here in the production, of course.
            // But in the earlier stages of your development, you may probably want to
            // add a lot of actions here until you finally completed setting up rbac,
            // otherwise you may not even take a first step.
        ]
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
