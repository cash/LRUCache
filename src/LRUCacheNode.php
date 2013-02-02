<?php

/**
 * A node class for the linked list in the LRUCache.
 *
 * This node class supports doubly linked lists. It is used to implement a
 * circular linked list in the LRUCache class.
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
	 * @param mixed $key   The key for the map in LRUCache
	 * @param mixed $value The value
	 */
	public function __construct($key, $value) {
		$this->key = $key;
		$this->value = $value;
	}

	/**
	 * Adds this node after the specified existing node
	 *
	 * @param LRUCacheNode $node
	 */
	public function insertAfter(LRUCacheNode $existingNode) {
		$this->next = $existingNode->next;
		$this->prev = $existingNode;
		$existingNode->next = $this;
		$this->next->prev = $this;
	}

	/**
	 * Remove this node from the linked list
	 */
	public function remove() {
		$this->prev->next = $this->next;
		$this->next->prev = $this->prev;
	}
}
