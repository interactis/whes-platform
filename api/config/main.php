<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),    
    'bootstrap' => ['log'],
    'controllerNamespace' => 'api\modules\v1\controllers',
    'modules' => [
        'v1' => [
            'class' => 'api\modules\v1\Module'
        ]
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
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
        'helpers' => [
 			'class' => 'api\modules\v1\components\Helpers',
 		],
        'request' => [
            // Enable JSON Input:
            'parsers' => [
                // 'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'urlManager' => [
        	'showScriptName' => false,
    		'enablePrettyUrl' => true,
    		'rules' => [
				'<controller:\w+>/<id:\d+>' => '<controller>/view',
				'v1' => 'site/index',
				'v1/<controller:\w+>/<id:\d+>' => '<controller>/view',
			],
		],
		'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];
