<?php

namespace Blog\Core\HandyBox;

class HandyBag
{
  private $collection;

  public function __construct(array $collection = [])
  {
    $this->collection = $collection;
  }

  public function getAll()
  {
    return $this->collection;
  }

  public function has($key)
  {
    return array_key_exists($key, $this->collection);
  }

  public function get($key, $default = null)
  {
    return array_key_exists($key, $this->collection) ? $this->collection[$key] : $default;
  }

  public function set($key, $value)
  {
    $this->collection[$key] = $value;
  }

  public function replace(array $collection)
  {
    $this->collection = $collection;
  }

  public function merge(array $collection)
  {
    $this->collection = array_merge($this->collection, $collection);
  }

  public function remove($key)
  {
    unset($this->collection[$key]);
  }

  public function count()
  {
    return count($this->collection);
  }
}