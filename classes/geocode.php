<?php

namespace Geocode;

class Geocode
{
	const SERVICE_URL = 'http://maps.googleapis.com/maps/api/geocode/';

	protected $format = 'xml';

	protected $sensor = true;

	protected $type;

	protected $params;

	public function __construct()
	{
		$args = func_get_args();

		$this->type = array_shift($args);

		$this->params = $args;
	}

	public static function address($address)
	{
		return new static('address', $address);
	}

	public static function reverse($lat, $long)
	{
		return new static('reverse', $lat, $long);
	}

	public function execute()
	{
		$url = $this->build_url();

		echo $url;
	}

	public function build_url()
	{
		if ($this->type = 'address')
		{
			$params = array('address' => $this->params[0]);
		}
		else
		{
			$params = array('latlng' => implode(',', $this->params));
		}

		$params['sensor'] = (bool) $this->sensor ? 'true' : 'false';

		$url = self::SERVICE_URL.$this->format.'?'.http_build_query($params, null, '&');

		return $url;
	}
}