<?php

namespace Geocode;

class Geocode_Response_Result
{
	/**
	 * ============================================
	 * ======== Constants for Reference ===========
	 * ============================================
	 */

	/**
	 * Location Types
	 * 
	 * They are ordered from most accurate to least accurate
	 * 
	 * @constant
	 */
	
	// Indicates that the returned result is a precise geocode for which we have location information accurate down to street address precision.
	const LT_ROOFTOP            = 'ROOFTOP';

	// Indicates that the returned result reflects an approximation (usually on a road) interpolated between two precise points (such as intersections). Interpolated results are generally returned when rooftop geocodes are unavailable for a street address.
	const LT_RANGE_INTERPOLATED = 'RANGE_INTERPOLATED';

	// Indicates that the returned result is the geometric center of a result such as a polyline (for example, a street) or polygon (region).
	const LT_GEOMETRIC_CENTER   = 'GEOMETRIC_CENTER';

	// Indicates that the returned result is approximate.
	const LT_APPROXIMATE        = 'APPROXIMATE';


	/**
	 * Address Component Types
	 * 
	 * @constant
	 */
	
	// Indicates a precise street address.
	const ACT_STREET_ADDRESS              = 'street_address';

	// Indicates a named route (such as "US 101").
	const ACT_ROUTE                       = 'route';

	// Indicates a major intersection, usually of two major roads.
	const ACT_INTERSECTION                = 'intersection';

	// Indicates a political entity. Usually, this type indicates a polygon of some civil administration.
	const ACT_POLITICAL                   = 'political';

	// Indicates the national political entity, and is typically the highest order type returned by the Geocoder.
	const ACT_COUNTRY                     = 'country';

	// Indicates a first-order civil entity below the country level. Within the United States, these administrative levels are states. Not all nations exhibit these administrative levels.
	const ACT_ADMINISTRATIVE_AREA_LEVEL_1 = 'administrative_area_level_1';

	// Indicates a second-order civil entity below the country level. Within the United States, these administrative levels are counties. Not all nations exhibit these administrative levels.
	const ACT_ADMINISTRATIVE_AREA_LEVEL_2 = 'administrative_area_level_2';

	// Indicates a third-order civil entity below the country level. This type indicates a minor civil division. Not all nations exhibit these administrative levels.
	const ACT_ADMINISTRATIVE_AREA_LEVEL_3 = 'administrative_area_level_3';

	// Indicates a commonly-used alternative name for the entity.
	const ACT_COLLOQUIAL_AREA             = 'colloquial_area';

	// Indicates an incorporated city or town political entity.
	const ACT_LOCALITY                    = 'locality';

	// Indicates an first-order civil entity below a locality.
	const ACT_SUBLOCALITY                 = 'sublocality';

	// Indicates a named neighborhood.
	const ACT_NEIGHBORHOOD                = 'neighborhood';

	// Indicates a named location, usually a building or collection of buildings with a common name
	const ACT_PREMISE                     = 'premise';

	// Indicates a first-order entity below a named location, usually a singular building within a collection of buildings with a common name
	const ACT_SUBPREMISE                  = 'subpremise';

	// Indicates a postal code as used to address postal mail within the country.
	const ACT_POSTAL_CODE                 = 'postal_code';

	// Indicates a prominent natural feature.
	const ACT_NATURAL_FEATURE             = 'natural_feature';

	// Indicates an airport.
	const ACT_AIRPORT                     = 'airport';

	// Indicates a named park.
	const ACT_PARK                        = 'park';

	// Indicates a named point of interest. Typically, these "POI"s are prominent local entities that don't easily fit in another category such as "Empire State Building" or "Statue of Liberty."
	const ACT_POINT_OF_INTEREST           = 'point_of_interest';

	// Indicates a specific postal box.
	const ACT_POST_BOX                    = 'post_box';

	// Indicates the precise street number.
	const ACT_STREET_NUMBER               = 'street_number';

	// Indicates the floor of a building address.
	const ACT_FLOOR                       = 'floor';

	// Indicates the room of a building address.
	const ACT_ROOM                        = 'room';



	/**
	 * ============================================
	 * =========== Class Properties ===============
	 * ============================================
	 */
	
	/**
	 * Types of results. This array indicates
	 * the type of the returned result. This array
	 * contains a set of one or more tags (Address
	 * Component types) identifying the type of
	 * feature returned in the result. For example,
	 * a geocode of "Chicago" returns "locality"
	 * which indicates that "Chicago" is a city,
	 * and also returns "political" which indicates
	 * it is a political entity.
	 */

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
	 * The location type
	 * 
	 * @var string
	 */
	protected $location_type;

	/**
	 * Viewport contains the recommended viewport
	 * for displaying the returned result, specified
	 * as two latitude,longitude values defining the
	 * southwest and northeast corner of the viewport
	 * bounding box. Generally the viewport is used
	 * to frame a result when displaying it to a user.
	 * 
	 * @var array
	 */
	protected $viewport = array();

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

		// Latitude and longitude
		$this->latitude  = $result['geometry']['location']['lat'];
		$this->longitude = $result['geometry']['location']['lng'];

		// Location type
		$this->location_type = $result['geometry']['location_type'];

		// Viewport coordinates
		$this->viewport['north_east'] = array(
			'latitude'  => $result['geometry']['viewport']['northeast']['lat'],
			'longitude' => $result['geometry']['viewport']['northeast']['lng'],
		);

		$this->viewport['south_west'] = array(
			'latitude'  => $result['geometry']['viewport']['southwest']['lat'],
			'longitude' => $result['geometry']['viewport']['southwest']['lng'],
		);




		unset($result['address_components']);
		unset($result['formatted_address']);
		unset($result['geometry']);

		echo '<pre>';
		print_r($result);
		echo '</pre>';
	}
}