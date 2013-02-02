<?php

class LRUCacheNodeTest extends PHPUnit_Framework_TestCase {

	function setUp() {
		$this->head = new LRUCacheNode(null, null);
		$this->nodes = array();
		$this->nodes[1] = new LRUCacheNode(1, 'test1');
		$this->nodes[2] = new LRUCacheNode(2, 'test2');
		$this->nodes[3] = new LRUCacheNode(3, 'test2');

		// head -> node1 -> node2 -> node3 -> head
		$this->head->next = $this->nodes[1];
		$this->head->prev = $this->nodes[3];
		$this->nodes[1]->next = $this->nodes[2];
		$this->nodes[1]->prev = $this->head;
		$this->nodes[2]->next = $this->nodes[3];
		$this->nodes[2]->prev = $this->nodes[1];
		$this->nodes[3]->next = $this->head;
		$this->nodes[3]->prev = $this->nodes[2];
	}

	function testInsertAfter() {
		// insert into a list that is already populated
		// head -> new -> node1 -> node2 -> node3 -> head
		$node = new LRUCacheNode(99, 'new');
		$node->insertAfter($this->head);
		$this->assertEquals($node, $this->head->next);
		$this->assertEquals($node, $this->nodes[1]->prev);
		$this->assertEquals($this->head, $node->prev);
		$this->assertEquals($this->nodes[1], $node->next);
	}

	function testInsertAfterEmptyList() {
		$this->head->next = $this->head->prev = $this->head;
		$node = new LRUCacheNode(99, 'new');
		$node->insertAfter($this->head);
		$this->assertEquals($node, $this->head->next);
		$this->assertEquals($node, $this->head->prev);
		$this->assertEquals($this->head, $node->prev);
		$this->assertEquals($this->head, $node->next);		
	}

	function testRemove() {
		$this->nodes[2]->remove();
		$this->assertEquals($this->nodes[3], $this->nodes[1]->next);
		$this->assertEquals($this->nodes[1], $this->nodes[3]->prev);
	}
}
