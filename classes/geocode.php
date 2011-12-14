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
namespace Geocode;

class Geocode
{
	/**
	 * The service url for geocoding information
	 * 
	 * @var string
	 */
	protected $service_url = 'http://maps.googleapis.com/maps/api/geocode/json';

	/**
	 * The type of geocoding we are doing,
	 * normal (address) or reverse (lat & long)
	 * 
	 * @var string
	 */
	public $type = 'address';

	/**
	 * The parameters used in
	 * the request
	 * 
	 * @var array
	 */
	public $params = array();

	/**
	 * Construct
	 * 
	 * Called when the class
	 * is initalised
	 * 
	 * @access  protected
	 * @param   string   $type     address|reverse  Type of geocode
	 * @param   array    $params   Parameters to override in this instance
	 */
	protected function __construct($type, array $params = array())
	{
		\Config::load('geocode', true);

		$this->params = \Arr::merge($this->params, \Config::get('geocode.default_params', array()), $params);
	}

	/**
	 * Address
	 * 
	 * Geocodes an address given.
	 * The address should be given with
	 * as many details as possible in a standard
	 * address format, however Google is pretty
	 * lenient
	 * 
	 * @access  public
	 * @param   string  $address  The address
	 * @param   array   $params   Parameters to override in this instance
	 * @param   bool    $execute  Excecute right away
	 * @return  mixed
	 */
	public static function address($address, array $params = array(), $execute = true)
	{
		$static = new static('address', \Arr::merge(array(
			'address' => $address,
		), $params));

		return $execute === true ? $static->execute() : $static;
	}

	/**
	 * Reverse
	 * 
	 * Reverse geocodes a location given.
	 * 
	 * @access  public
	 * @param   decimal $lat      The latitude
	 * @param   decimal $long     The longitude
	 * @param   array   $params   Parameters to override in this instance
	 * @param   bool    $execute  Excecute right away
	 * @return  mixed
	 */
	public static function reverse($lat, $long, array $params = array(), $execute = true)
	{
		$static = new static('reverse', \Arr::merge(array(
			'latlng' => $lat.','.$long,
		), $params));

		return $execute === true ? $static->execute() : $static;
	}

	/**
	 * Execute
	 * 
	 * Executes the geocode and returns a response object
	 * with the results
	 */
	public function execute()
	{
		// Build the url
		$url = $this->build_url();

		try
		{
			$request = \Request::forge($url, array(
				'driver' => 'curl',
			));
			$request->set_option('timeout', \Config::get('geocode.request_timeout', 30));

			$body = $request->execute()->response()->body();

			return new \Geocode_Response($body, 'json');
		}
		catch (\RequestException $e)
		{
			if ($request->response_info('http_code', false) == '404')
			{
				throw new \Exception('The geocode resource could not be found (404) ['.$url.']');
			}

			throw new \Exception('Curl request exception: '.
				$message = $e->getMessage() ? '"'.$message.'"' : 'No message specified.');
		}
	}

	/**
	 * Build Url
	 * 
	 * Returns the url we need to
	 * access
	 * 
	 * @access  protected
	 * @return  string   Url
	 */
	protected function build_url()
	{
		return $this->service_url.'?'.http_build_query($this->params, null, '&');
	}
}