<?php

namespace Geocode;

class Geocode
{
	/**
	 * The service url for geocoding information
	 * 
	 * @var string
	 */
	protected $service_url = 'http://amaps.googleapis.com/maps/api/geocode/json';

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
	 */
	public $params = array();

	protected function __construct($type, $params = array())
	{
		\Config::load('geocode', true);

		$this->params = \Arr::merge($this->params, \Config::get('geocode.default_params', array()), $params);
	}

	public static function address($address)
	{
		return new static('address', array(
			'address' => $address,
		));
	}

	public static function reverse($lat, $long)
	{
		return new static('reverse', array(
			'latlng' => $lat.','.$lng,
		));
	}

	public function execute()
	{
		$url = $this->build_url();

		try
		{
			$request = \Request::forge($url, array(
				'driver' => 'curl',
			));
			$request->set_option('timeout', 3);

			$body = $request->execute()->response()->body();

			\Debug::dump($body);
		}
		catch (\RequestException $e)
		{
			if ($request->response_info('http_code', false) == '404')
			{
				throw new \Exception('The geocode resource could not be found (404)');
			}

			throw new \Exception('Curl request exception: '.
				$message = $e->getMessage() ? '"'.$message.'"' : 'No message specified.');
		}
	}

	public function build_url()
	{

		$url = $this->service_url.'?'.http_build_query($this->params, null, '&');

		return $url;
	}
}