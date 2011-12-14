<?php
/**
 * Google Geocoder package for FuelPHP
 *
 * @package    FuelPHP
 * @subpackage Geocoder
 * @version    1.0
 * @author     Webcomm (http://www.webcomm.com.au)
 * @license    MIT License
 * @copyright  2011 Webcomm Pty Limited
 * @link       http://github.com/bencorlett/fuel-geocoder
 * @see        http://code.google.com/apis/maps/documentation/geocoding
 */
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