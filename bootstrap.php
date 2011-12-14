<?php

Autoloader::add_core_namespace('Geocode');

Autoloader::add_classes(array(

	// Classes
	'Geocode\\Geocode'                 => __DIR__.'/classes/geocode.php',
	'Geocode\\Geocode_Response'        => __DIR__.'/classes/geocode/response.php',
	'Geocode\\Geocode_Response_Result' => __DIR__.'/classes/geocode/response/result.php',

	// Exceptions
	'Geocode\\NoResultsException'       => __DIR__.'/classes/geocode/response.php',
	'Geocode\\InvalidResponseException' => __DIR__.'/classes/geocode/response.php',
));