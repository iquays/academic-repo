<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'simikri',
    'name' => 'SIMikro',
//    'language' => 'en-EN',
    'language' => 'id-ID',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'app\components\Aliases'],
    'modules' => [
        'gridview' => [
            'class' => '\kartik\grid\Module'
        ],
        'datecontrol' => [
            'class' => '\kartik\datecontrol\Module',
            'displaySettings' => [
                \kartik\datecontrol\Module::FORMAT_DATE => 'medium',
            ],
            'autoWidget' => true,
            'autoWidgetSettings' => [
                \kartik\datecontrol\Module::FORMAT_DATE => [
                    'type' => \kartik\widgets\DatePicker::TYPE_COMPONENT_APPEND,
                    'removeButton' => false,
                    'pickerButton' => '<span class="input-group-addon kv-date-calendar" title="' . Yii::t('app', 'Select date') . '"><i class="fa fa-calendar"></i></span>',
                    'pluginOptions' => ['autoclose' => true, 'todayHighlight' => true]
                ], // example
            ],
        ]
    ],
    'components' => [
        'formatter' => [
            'currencyCode' => 'IDR',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'ywqsIU_brHlejqfDpkhBHmOB7l-Xqc-p',
        ],
        // you can set your theme here - template comes with: 'light' and 'dark'
//        'view' => [
//            'class' => '\rmrevin\yii\minify\View',
//            'enableMinify' => !YII_DEBUG,
////            'enableMinify' => true,
//            'webPath' => '@web', // path alias to web base
//            'basePath' => '@webroot', // path alias to web base
//            'minifyPath' => '@webroot/assets/minify', // path alias to save minify result
//            'minifyOutput' => true, // minificate result html page
//            'jsPosition' => [\yii\web\View::POS_END], // positions of js files to be minified
//            'forceCharset' => 'UTF-8', // charset forcibly assign, otherwise will use all of the files found charset
//            'expandImports' => false, // whether to change @import on content
//            'concatCss' => true, // concatenate css
//            'minifyCss' => true, // minificate css
//            'concatJs' => false, // concatenate js
//            'minifyJs' => true, // minificate js
//            'theme' => [
//                'pathMap' => ['@app/views' => '@webroot/themes/default/views'],
////                'baseUrl' => '@web/themes',
//            ],
//        ],
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => [
                        YII_ENV_DEV ? 'jquery.js' : 'jquery.min.js'
                    ]
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'sourcePath' => '@bower/bootstrap-customized/css',
                    'css' => [
                        YII_ENV_DEV ? 'bootstrap.css' : 'bootstrap.min.css',
                    ]
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'sourcePath' => '@bower/bootstrap-customized/js',
                    'js' => [
                        YII_ENV_DEV ? 'bootstrap.js' : 'bootstrap.min.js',
                    ]
                ]
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<alias:\w+>' => 'site/<alias>',
            ],
        ],
        'user' => [
            'identityClass' => 'app\models\UserIdentity',
//            'enableAutoLogin' => true,
            'enableSession' => true,
            'authTimeout' => 60 * 9,
        ],
        'session' => [
            'class' => 'yii\web\DbSession',
//            'savePath' => '@app/runtime/session'
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'cache' => 'cache',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',  // e.g. smtp.mandrillapp.com or smtp.gmail.com
                'username' => 'syauqi.main@gmail.com',
                'password' => 'tsshajlxsyisfccq',
                'port' => '587', // Port 25 is a very common port too
                'encryption' => 'tls', // It is often used, check your provider or mail server specs
            ],
            // send all mails to a file by default. 
            // You have to set 'useFileTransport' to false and configure a transport for the mailer to send real emails.
            'useFileTransport' => false,
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
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/translations',
                    'sourceLanguage' => 'en',
                ],
                'yii' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/translations',
                    'sourceLanguage' => 'en'
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = ['class' => 'yii\debug\Module'];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [
            'crud' => [
                'class' => 'yii\gii\generators\crud\Generator',
                'templates' => ['myCRUD' => '@app/templates/crud']
            ]
        ]
    ];
}

return $config;
