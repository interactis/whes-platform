<?php
return [
	'supportedLanguages' => ['de', 'en', 'fr', 'it'],
	'languageIds' => ['de' => 1, 'en' => 2, 'fr' => 3, 'it' => 4],
    'preferredLanguageId' => 1, // preferred DE = default
    'secondaryLanguageId' => 2, // secondary EN
	
    'adminEmail' => 'info@interactis.ch',
    'supportEmail' => 'info@interactis.ch',
    'senderEmail' => 'info@ourheritage.ch',
    'senderName' => 'Our Heritage',
    'user.passwordResetTokenExpire' => 3600,
    'user.passwordMinLength' => 8,
    
    'imageFormats' => [
    	'crop' => [
    		["width" => 400, "height" => 400],
    		["width" => 600, "height" => 600],
    		["width" => 900, "height" => 506],
    		["width" => 1200, "height" => 675],
    		["width" => 1600, "height" => 900],
    	],
    	'ratio' => [
    		["width" => 400, "height" => 225],
    		["width" => 600, "height" => 338],
    		["width" => 900, "height" => 506],
    		["width" => 1200, "height" => 675],
    		["width" => 1600, "height" => 900],
    	]
    ],
    
    'geoAdminSearchUrl' => 'https://api3.geo.admin.ch/rest/services/api/SearchServer',
];
