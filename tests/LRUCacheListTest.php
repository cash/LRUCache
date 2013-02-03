<?php

class LRUCacheListTest extends PHPUnit_Framework_TestCase {

	function setUp() {
		$this->list = new LRUCacheList();
		$this->nodes = array();
		$this->nodes[1] = new LRUCacheNode(1, 'test1');
		$this->nodes[2] = new LRUCacheNode(2, 'test2');
		$this->nodes[3] = new LRUCacheNode(3, 'test2');
	}

	function insertNodes() {
		// head -> node1 -> node2 -> node3 -> head
		$this->list->head->next = $this->nodes[1];
		$this->list->head->prev = $this->nodes[3];
		$this->nodes[1]->next = $this->nodes[2];
		$this->nodes[1]->prev = $this->list->head;
		$this->nodes[2]->next = $this->nodes[3];
		$this->nodes[2]->prev = $this->nodes[1];
		$this->nodes[3]->next = $this->list->head;
		$this->nodes[3]->prev = $this->nodes[2];
	}

	function testInsertAfter() {
		// insert into a list that is already populated
		// head -> new -> node1 -> node2 -> node3 -> head
		$this->insertNodes();
		$node = new LRUCacheNode(99, 'new');
		$this->list->insertAfter($node, $this->list->head);
		$this->assertEquals($node, $this->list->head->next);
		$this->assertEquals($node, $this->nodes[1]->prev);
		$this->assertEquals($this->list->head, $node->prev);
		$this->assertEquals($this->nodes[1], $node->next);
	}

	function testInsertAfterEmptyList() {
		$node = new LRUCacheNode(99, 'new');
		$this->list->insertAfter($node, $this->list->head);
		$this->assertEquals($node, $this->list->head->next);
		$this->assertEquals($node, $this->list->head->prev);
		$this->assertEquals($this->list->head, $node->prev);
		$this->assertEquals($this->list->head, $node->next);
	}

	function testRemove() {
		$this->insertNodes();
		$this->list->remove($this->nodes[2]);
		$this->assertEquals($this->nodes[3], $this->nodes[1]->next);
		$this->assertEquals($this->nodes[1], $this->nodes[3]->prev);
	}

	function testGetTail() {
		$this->insertNodes();
		$this->assertSame($this->nodes[3], $this->list->getTail());
	}
}
