<?php

namespace cash;

/**
 * Least Recently Used Cache
 *
 * A fixed sized cache that removes the element used last when it reaches its
 * size limit.
 */
class LRUCache {

    /** @var int */
    protected $maximumSize;

    /**
     * The front of the array contains the LRU element
     *
     * @var array
     */
    protected $data = array();

    /**
     * Create a LRU Cache
     *
     * @param int $size
     * @throws \InvalidArgumentException
     */
    public function __construct($size) {
        if (!is_int($size) || $size <= 0) {
            throw new \InvalidArgumentException();
        }
        $this->maximumSize = $size;
    }

    /**
     * Get the value cached with this key
     *
     * @param int|string $key     The key. Strings that are ints are cast to ints.
     * @param mixed      $default The value to be returned if key not found. (Optional)
     * @return mixed
     */
    public function get($key, $default = null) {
        if (isset($this->data[$key])) {
            $this->recordAccess($key);
            return $this->data[$key];
        } else {
            return $default;
        }
    }

    /**
     * Put something in the cache
     *
     * @param int|string $key   The key. Strings that are ints are cast to ints.
     * @param mixed      $value The value to cache
     */
    public function put($key, $value) {
        if (isset($this->data[$key])) {
            $this->data[$key] = $value;
            $this->recordAccess($key);
        } else {
            $this->data[$key] = $value;
            if ($this->size() > $this->maximumSize) {
                // remove least recently used element (front of array)
                reset($this->data);
                unset($this->data[key($this->data)]);
            }
        }
    }

    /**
     * Get the number of elements in the cache
     *
     * @return int
     */
    public function size() {
        return count($this->data);
    }

    /**
     * Does the cache contain an element with this key
     *
     * @param int|string $key The key
     * @return boolean
     */
    public function containsKey($key) {
        return isset($this->data[$key]);
    }

    /**
     * Remove the element with this key.
     *
     * @param int|string $key The key
     * @return mixed Value or null if not set
     */
    public function remove($key) {
        if (isset($this->data[$key])) {
            $value = $this->data[$key];
            unset($this->data[$key]);
            return $value;
        } else {
            return null;
        }
    }

    /**
     * Clear the cache
     */
    public function clear() {
        $this->data = array();
    }

    /**
     * Moves the element from current position to end of array
     * 
     * @param int|string $key The key
     */
    protected function recordAccess($key) {
        $value = $this->data[$key];
        unset($this->data[$key]);
        $this->data[$key] = $value;
    }

}