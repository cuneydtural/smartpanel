<?php

return [
	'debug'               			=> true,
	'API_URL'             			=> 'api.twitter.com',
	'UPLOAD_URL'         			=> 'upload.twitter.com',
	'API_VERSION'         			=> '1.1',
	'AUTHENTICATE_URL'    			=> 'https://api.twitter.com/oauth2/token',
	'AUTHORIZE_URL'       			=> 'https://api.twitter.com/oauth/authorize',
	'ACCESS_TOKEN_URL'    			=> 'https://api.twitter.com/oauth/access_token',
	'REQUEST_TOKEN_URL'   			=> 'https://api.twitter.com/oauth/request_token',
	'USE_SSL'             			=> true,

	'CONSUMER_KEY'       			=> env('TWITTER_CONSUMER_KEY'),
	'TWITTER_CONSUMER_SECRET'     	=> env('TWITTER_CONSUMER_SECRET'),
	'TWITTER_ACCESS_TOKEN'        	=> env('TWITTER_ACCESS_TOKEN'),
	'TWITTER_ACCESS_TOKEN_SECRET' 	=> env('TWITTER_ACCESS_TOKEN_SECRET'),
];
