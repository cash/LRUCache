<?php

/**
 * A node class for the linked list in the LRUCache.
 *
 */
class LRUCacheNode {
	public $key;

	public $value;

	/* @var LRUCacheNode */
	public $next = null;

	/* @var LRUCacheNode */
	public $prev = null;

	/**
	 * Create a node for the linked list
	 *
	 * @param mixed $key   The key for cache
	 * @param mixed $value The value to be cached
	 */
	public function __construct($key, $value) {
		$this->key = $key;
		$this->value = $value;
	}
}
