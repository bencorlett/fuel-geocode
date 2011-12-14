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
return array(

	/**
	 * How long shall the curl
	 * request wait until it
	 * times out
	 */
	'request_timeout' => 30,

	/**
	 * Default parameters for
	 * requests
	 */
	'default_params' => array(
		'sensor' => 'true',
		'lang'   => 'en',
	),	
);