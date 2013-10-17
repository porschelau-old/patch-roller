<?php
/**
 * Collection set to help model the return result from the db
 *
 * The goal is not to generate the DAO object upfront but only create the DAO object from the buffer when
 * we actually use it.
 *
 */
namespace app\model;

class QueryResultCollection implements \Iterator{

	/**
	 * This is the mysqli_result object
	 *
	 * @link http://www.php.net/manual/en/class.mysqli-result.php
	 *
	 * @var mysqli_result
	 */
	private $result;
	private $daoName;
	private $pointer = 0;
	private $current = null;

	public function __construct($daoName, $result) {
		$this->result = $result;
		$this->daoName = $daoName;
	}

	/**
	 * Return the number of on the record set
	 * @return int
	 */
	public function length() {
		return $this->result->num_rows;
	}

	/**
	 * Return the current object from the result set, if we have not yet called next to get the next one
	 * we will try to call next() for the caller.
	 * (non-PHPdoc)
	 * @see Iterator::current()
	 */
	public function current() {
		if ($this->current == null) {
			$this->next();
		}
		return $this->current;
	}

	/**
	 * Retrieve the data from the result buffer and generate a DAO object from that
	 * (non-PHPdoc)
	 * @see Iterator::next()
	 */
	public function next () {

		$data = $this->result->fetch_assoc();

		//create the DAO object
		$className = $this->daoName;
		$this->current = new $className($data);

		//increment the pointer
		$this->pointer++;

		return $this->current;
	}

	/**
	 * Get the position for the current object
	 * (non-PHPdoc)
	 * @see Iterator::key()
	 */
	public function key () {
		$key = $this->pointer-1;
		return ($key > 0) ? $key : 0;
	}

	/**
	 * Check to see if the current current is accessible on the result set. We can do it by the data seek method
	 * (non-PHPdoc)
	 * @see Iterator::valid()
	 */
	public function valid () {
		return $this->result->data_seek($this->pointer);
	}

	/**
	 * Put the point back to zero and do a data seek on that
	 * (non-PHPdoc)
	 * @see Iterator::rewind()
	 */
	public function rewind () {
		$this->pointer = 0;
		$this->result->data_seek($this->pointer);
	}

	/**
	 * Close the result set so it frees up the space
	 */
	public function close() {
		$this->result->close();
	}
}