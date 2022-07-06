<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'i18n' => [
        	'translations' => [
        	    'app*' => [
        	        'class' => 'yii\i18n\PhpMessageSource',
        	        'basePath' => '@common/messages',
        	    ],
        	],
    	],
    	'helpers' => [
 			'class' => 'common\components\Helpers',
 		],
    ],
];
