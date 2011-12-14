<?php

namespace Geocode;

class Geocode_Response_Result
{
	/**
	 * Formatted address
	 * 
	 * @var string
	 */
	protected $formatted_address;

	/**
	 * The latitude
	 * 
	 * @var decimal
	 */
	protected $latitude;

	/**
	 * The longitude
	 * 
	 * @var decimal
	 */
	protected $longitude;

	/**
	 * Address compontents
	 * 
	 * @var array
	 */
	protected $address_components = array();

	public function __construct($result)
	{
		// The formatted address
		$this->formatted_address = $result['formatted_address'];

		foreach ($result['address_components'] as $component)
		{
			$this->address_components[] = $component;
		}

		unset($result['address_components']);
		unset($result['formatted_address']);

		echo '<pre>';
		print_r($result);
		echo '</pre>';

		// Latitude and longitude
		$this->latitude  = $result['geometry']['location']['lat'];
		$this->longitude = $result['geometry']['location']['lng'];
	}
}