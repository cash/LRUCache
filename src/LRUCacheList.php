<?php

/**
 * Circular doubly linked list
 *
 * This implements those methods needed by the LRUCache.
 */
class LRUCacheList {
	/* @var LRUCacheNode */
	public $head;

	public function __construct() {
		// the head is a null element that always points the most and least recently
		// used elements
		$this->head = new LRUCacheNode(null, null);
		$this->head->next = $this->head->prev = $this->head;
	}

	/**
	 * Adds a new node after the specified existing node
	 *
	 * @param LRUCacheNode $newNode      New node to add to the list
	 * @param LRUCacheNode $existingNode Node already in the list
	 */
	public function insertAfter(LRUCacheNode $newNode, LRUCacheNode $existingNode) {
		$newNode->next = $existingNode->next;
		$newNode->prev = $existingNode;
		$existingNode->next = $newNode;
		$newNode->next->prev = $newNode;
	}

	/**
	 * Convenience method to insert after the head
	 *
	 * @param LRUCacheNode $newNode New node to add to the list
	 */
	public function insertAfterHead(LRUCacheNode $newNode) {
		$this->insertAfter($newNode, $this->head);
	}

	/**
	 * Remove this node from the linked list
	 *
	 * @param LRUCacheNode $node The node to remove
	 */
	public function remove($node) {
		$node->prev->next = $node->next;
		$node->next->prev = $node->prev;
	}

	/**
	 * Get the tail node
	 *
	 * @return LRUCacheNode
	 */
	public function getTail() {
		return $this->head->prev;
	}
}
