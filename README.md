#FuelPHP Geocode package

* [Website](http://github.com/bencorlett/fuel-geocode/)

## Description

The FuelPHP Geocode package is a FuelPHP package that interacts with the 

##What is Geocoding?

[Straight from the horse's mouth](http://code.google.com/apis/maps/documentation/geocoding/#Geocoding):

    Geocoding is the process of converting addresses (like "1600 Amphitheatre Parkway, Mountain View, CA") into geographic coordinates (like latitude 37.423021 and longitude -122.083739), which you can use to place markers or position the map. The Google Geocoding API provides a direct way to access a geocoder via an HTTP request. Additionally, the service allows you to perform the converse operation (turning coordinates into addresses); this process is known as "reverse geocoding."

##Usage

###Normal Geocoding

    $results = \Geocode::address('19 Gateway Boulevarde, Morisset NSW 2264 Australia');

    foreach ($results as $result)
    {
        echo $result->latitude() . ' ' . $result->longitude();

        echo $result->component('street_number', 'short');

        /**
         * Below is a list of components
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
    }


###Reverse Geocoding

    $result = \Geocode::reverse(-33.11721220, 151.47154220)->first();

    echo $result->formatted_address();

## Docs

I will write up docs one day for the package. Until then, have a browse through the classes