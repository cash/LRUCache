<?php

/**
 * Least Recently Used Cache
 *
 * A fixed sized cache that removes the element used last when it reaches its
 * size limit.
 */
class LRUCache {
	protected $maximumSize = 0;
	protected $map = array();
	protected $head = null;

	/**
	 * Create a LRU Cache
	 *
	 * @param int $size
	 * @throws InvalidArgumentException
	 */
	public function __construct($size) {
		if (!is_int($size) || $size <= 0) {
			throw new InvalidArgumentException();
		}
		$this->maximumSize = $size;

		$this->head = new LRUCacheNode(null, null);
		$this->head->after = $this->head->before = $this->head;
	}

	/**
	 * Get the value cached with this key
	 *
	 * @param mixed $key      The key
	 * @param mixed $default  The value to be returned if key not found. (Optional)
	 * @return mixed
	 */
	public function get($key, $default = null) {
		if ($this->containsKey($key)) {
			$this->recordAccess($this->map[$key]);
			return $this->map[$key]->value;
		} else {
			return $default;
		}
	}

	/**
	 * Put something in the cache
	 *
	 * @param mixed $key   The key
	 * @param mixed $value The value to cache
	 */
	public function put($key, $value) {
		if ($this->containsKey($key)) {
			$this->map[$key]->value = $value;
			$this->recordAccess($this->map[$key]);
		} else {
			$node = new LRUCacheNode($key, $value);
			$this->add($node);
			if ($this->size() > $this->maximumSize) {
				$this->removeStalestNode();
			}
		}
	}

	/**
	 * Get the number of elements in the cache
	 *
	 * @return int
	 */
	public function size() {
		return count($this->map);
	}

	/**
	 * Does the cache contain an element with this key
	 *
	 * @param mixed $key The key
	 * @return boolean
	 */
	public function containsKey($key) {
		if (isset($this->map[$key])) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Remove the element with this key.
	 *
	 * @param mixed $key The key
	 */
	public function remove($key) {
		if ($this->containsKey($key)) {
			$this->map[$key]->remove();
			unset($this->map[$key]);
		}
	}

	protected function add(LRUCacheNode $node) {
		$this->map[$key] = $node;
		$node->addBefore($this->head);
	}

	protected function recordAccess(LRUCacheNode $node) {
		$node->remove();
		$node->addBefore($this->head);
	}

	protected function removeStalestNode() {
		$this->remove($this->head->after->key);
	}
}