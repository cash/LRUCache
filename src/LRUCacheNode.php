<?php

/**
 * A node class for the linked list in the LRUCache.
 *
 * This is used to implement a circular linked list where the node before the
 * head is the most recently used element and the node after the head is the
 * least recently used element.
 */
class LRUCacheNode {
	public $key;

	public $value;

	/* @var LRUCacheNode */
	public $before = null;

	/* @var LRUCacheNode */
	public $after = null;

	/**
	 * Create a node for the linked list
	 *
	 * @param mixed $key   The key for the map in LRUCache
	 * @param mixed $value The value
	 */
	public function __construct($key, $value) {
		$this->key = $key;
		$this->value = $value;
	}

	/**
	 * Adds this node before the specified existing node
	 *
	 * @param LRUCacheNode $node
	 */
	public function addBefore(LRUCacheNode $existingNode) {
		$this->after = $existingNode;
		$this->before = $existingNode->before;
		$this->before->after = $this;
		$this->after->before = $this;
	}

	/**
	 * Remove this node from the linked list
	 */
	public function remove() {
		$this->before->after = $this->after;
		$this->after->before = $this->before;
	}
}
