<?php

namespace Geocode;

class NoResultsException       extends \Exception {}
class InvalidResponseException extends \Exception {}

class Geocode_Response implements \ArrayAccess, \Iterator, \Countable
{
	/**
	 * ============================================
	 * ======== Constants for Reference ===========
	 * ============================================
	 */
	
	/**
	 * Available statuses
	 * 
	 * @constant
	 */
	
	// Indicates that no errors occurred; the address was successfully parsed and at least one geocode was returned.
	const STATUS_OK               = "OK";

	// Indicates that the geocode was successful but returned no results. This may occur if the geocode was passed a non-existent address or a latlng in a remote location.
	const STATUS_ZERO_RESULTS     = "ZERO_RESULTS";

	// Indicates that you are over your quota.
	const STATUS_OVER_QUERY_LIMIT = "OVER_QUERY_LIMIT";

	// Indicates that your request was denied, generally because of lack of a sensor parameter.
	const STATUS_REQUEST_DENIED   = "REQUEST_DENIED";

	// Generally indicates that the query (address or latlng) is missing.
	const STATUS_INVALID_REQUEST  = "INVALID_REQUEST";



	/**
	 * ============================================
	 * =========== Class Properties ===============
	 * ============================================
	 */
	

	/**
	 * Invalid statuses
	 * 
	 * @var array
	 */
	protected $invalid_statuses = array(
		self::STATUS_OVER_QUERY_LIMIT,
		self::STATUS_REQUEST_DENIED,
		self::STATUS_INVALID_REQUEST,
	);

	/**
	 * An array of results come back
	 * 
	 * @var array
	 */
	protected $results = array();

	/**
	 * A counter used for iterating
	 * over results
	 * 
	 * @var int
	 */
	protected $counter = 0;

	/**
	 * Construct
	 * 
	 * Called when the class is initalised
	 * 
	 * @access  public
	 * @param   string  $body   Raw response body
	 */
	public function __construct($body)
	{
		$body = \Format::forge($body, 'json')
					   ->to_array();
		
		// Make sure we have results
		$status = $body['status'];

		if (in_array($status, $this->invalid_statuses))
		{
			throw new \InvalidResponseException('Geocde request failed with status: '.$status);
		}
		elseif ($status == self::STATUS_ZERO_RESULTS)
		{
			throw new \NoResultsException('No results were found for the requested geocode.');
		}

		foreach ($body['results'] as $result)
		{
			$this->results[] = new \Geocode_Response_Result($result);
		}
	}

	/**
	 * First
	 * 
	 * Shortcut to getting the first
	 * result:
	 * 
	 * $result = \Geocode::address('1 Infinite Loop, CA USA')
	 * 					 ->first();
	 * 
	 * As opposed to:
	 * 
	 * $results = \Geocode::address('1 Inifite Loop, CA USA');
	 * $result  = $results[0];
	 * 
	 * It's more of a preferences thing
	 * than anythign else
	 * 
	 * @access  public
	 * @return  Geocode\Geocde_Response_Result
	 */
	public function first()
	{
		return $this->results[0];
	}

	/**
	 * ============================================
	 * ========= Countable Implementation =========
	 * ============================================
	 */
	
	/**
	 * ArrayAccess::offsetExists
	 * 
	 * @see http://php.net/manual/en/arrayaccess.offsetexists.php
	 */
	public function offsetExists($offset)
	{
		return isset($this->results[$offset]);
	}

	/**
	 * ArrayAccess::offsetGet
	 * 
	 * @see http://php.net/manual/en/arrayaccess.offsetget.php
	 */
	public function offsetGet($offset)
	{
		if ( ! $this->offsetExists($offset))
		{
			throw new \OutOfboundsException('Offset ' . $offset . ' doesn\'t exist');
		}

		return $this->results[$offset];
	}

	/**
	 * ArrayAccess::offsetSet
	 * 
	 * @see http://php.net/manual/en/arrayaccess.offsetset.php
	 */
	public function offsetSet($offset, $result)
	{
		$this->results[$offset] = $result;
	}

	/**
	 * ArrayAccess::offsetUnset
	 * 
	 * @see http://php.net/manual/en/arrayaccess.offsetunset.php
	 */
	public function offsetUnset($offset)
	{
		unset($this->results[$offset]);
	}

	/**
	 * ============================================
	 * ========= Iterable Implementation ==========
	 * ============================================
	 */
	
	/**
	 * Iterator::current
	 * 
	 * @see http://php.net/manual/en/class.iterator.php
	 */
	public function current()
	{
		return $this->results[$this->counter];
	}

	/**
	 * Iterator::next
	 * 
	 * @see http://php.net/manual/en/class.iterator.php
	 */
	public function next()
	{
		++$this->counter;
		return $this;
	}

	/**
	 * Iterator::key
	 * 
	 * @see http://php.net/manual/en/class.iterator.php
	 */
	public function key()
	{
		return $this->counter;
	}

	/**
	 * Iterator::valid
	 * 
	 * @see http://php.net/manual/en/class.iterator.php
	 */
	public function valid()
	{
		return $this->offsetExists($this->counter);
	}

	/**
	 * Iterator::rewind
	 * 
	 * @see http://php.net/manual/en/class.iterator.php
	 */
	public function rewind()
	{
		$this->counter = 0;
	}

	/**
	 * ============================================
	 * ========= Countable Implementation =========
	 * ============================================
	 */

	/**
	 * Count
	 * 
	 * Returns the count of results
	 * 
	 * @access  public
	 * @return  int
	 * @see     Countable::count [http://www.php.net/manual/en/class.countable.php]
	 */
	public function count()
	{
		return count($this->results);
	}
}