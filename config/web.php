<?php

use app\models\CalculateRequestForm;
use app\models\GetCryptocurrencyRequestForm;
use app\src\Repository\CryptocurrencyRepository;
use app\src\Repository\Interface\CryptocurrencyRepositoryInterface;
use app\src\Service\CryptocurrencyCalculateService;
use app\src\Service\CryptocurrencyUpdateService;
use app\src\Service\Interface\CryptocurrencyCalculateServiceInterface;
use app\src\Service\Interface\CryptocurrencyUpdateServiceInterface;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '3-DHVP-CCyz73XfKUUYGSWv3rKGxDd6M',
            'enableCsrfValidation' => false
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
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
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
                'cryptocurrencies/update' => 'cryptocurrencies/update',
                'cryptocurrencies/calculate' => 'cryptocurrencies/calculate',
                'cryptocurrencies/<symbol:\w+>' => 'cryptocurrencies/symbol',
            ],
        ],
        'response' => [
            'format' => yii\web\Response::FORMAT_JSON,
            'charset' => 'UTF-8',
        ],
    ],
    'container' => [
        'definitions' => [
            'GuzzleHttp\Client' => [
                'class' => GuzzleHttp\Client::class,
            ],
            CryptocurrencyUpdateServiceInterface::class => [
                'class' => CryptocurrencyUpdateService::class,
                'client' => \yii\di\Instance::of('GuzzleHttp\Client')
            ],
            CryptocurrencyRepositoryInterface::class => [
                'class' => CryptocurrencyRepository::class,
            ],
            CryptocurrencyCalculateServiceInterface::class => [
                'class' => CryptocurrencyCalculateService::class,
            ],
            GetCryptocurrencyRequestForm::class => [
                'class' => GetCryptocurrencyRequestForm::class,
            ],
            CalculateRequestForm::class => [
                'class' => CalculateRequestForm::class,
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
