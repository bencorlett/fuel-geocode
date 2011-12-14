<?php

namespace Geocode;

class NoResultsException       extends \Exception {}
class InvalidResponseException extends \Exception {}

class Geocode_Response implements \ArrayAccess, \Iterator, \Countable
{
	/**
	 * Available statuses
	 * 
	 * @constant
	 */
	const STATUS_OK               = "OK";
	const STATUS_ZERO_RESULTS     = "ZERO_RESULTS";
	const STATUS_OVER_QUERY_LIMIT = "OVER_QUERY_LIMIT";
	const STATUS_REQUEST_DENIED   = "REQUEST_DENIED";
	const STATUS_INVALID_REQUEST  = "INVALID_REQUEST";

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

	public function __construct($body, $type)
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
			throw new \NoResultsException('Zero results found for the requested geocode.');
		}

		foreach ($body['results'] as $result)
		{
			$this->results[] = new \Geocode_Response_Result($result);
		}
	}

	/**
	 * ============================================
	 * ====== Methods used when iterating =========
	 * ============================================
	 */

	/**
	 * ============================================
	 * ========= Countable Implementation =========
	 * ============================================
	 */
	
	public function offsetExists($offset)
	{
		return isset($this->results[$offset]);
	}

	public function offsetGet($offset)
	{
		if ( ! $this->offsetExists($offset))
		{
			throw new \OutOfboundsException('Offset ' . $offset . ' doesn\'t exist');
		}

		return $this->results[$offset];
	}

	public function offsetSet($offset, $result)
	{
		$this->results[$offset] = $result;
	}

	public function offsetUnset($offset)
	{
		unset($this->results[$offset]);
	}

	/**
	 * ============================================
	 * ========= Iterable Implementation ==========
	 * ============================================
	 */
	public function current()
	{
		return $this->results[$this->counter];
	}

	public function next()
	{
		++$this->counter;
		return $this;
	}

	public function key()
	{
		return $this->counter;
	}

	public function valid()
	{
		return $this->offsetExists($this->counter);
	}

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