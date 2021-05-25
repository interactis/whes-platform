<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'helpers' => [
 			'class' => 'frontend\components\Helpers',
 		],
        // disable yii jquery and css because it's already part of gulp app
        'assetManager' => [
            'bundles' => [
                /*
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,   // do not publish the bundle
                    'js' => [
                        '/js/theme.min.js',  // use custom jquery
                    ]
                ],
                */
                'yii\bootstrap\BootstrapAsset' => [
                    'sourcePath' => null,   // do not publish the bundle
                    'css' => [
                        '/css/theme.min.css',  // use custom bootstrap css
                	]
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                	'js'=>[]
                ],
            ],
        ],
    	'urlManager' => [
        	'showScriptName' => false,
    		'enablePrettyUrl' => true,
    		'rules' => [
    			'search' =>'search/index',
    			'map/<select:[\w\-]+>/<id:\d+>' =>'map/index',
    			'map' =>'map/index',
    			
    			'<slug:[\w\-]+>' =>'heritage/view',
    			'article/<slug:[\w\-]+>' =>'article/view',
    			//'artikel/<slug:[\w\-]+>' => 'article/view',
    			//'artikel' => 'article/index',
    			'poi/<slug:[\w\-]+>' =>'poi/view',
    			'route/<slug:[\w\-]+>' =>'route/view',
    			
        		'<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
    		],
		],
    ],
    'bootstrap' => [
        [
            'class' => 'frontend\components\BootstrapSelector',
        ],
    ],
    'params' => $params,
];
