<?php

namespace Blog\Core\HandyBox;

use Blog\Core\HandyBox\HandyBoxInterface;
use Blog\Core\HandyBox\HandyBag;
use Blog\Core\Exception\UnknownIdentifierException;

class HandyBoxContainer
{
  private $factories = [];
  private $services = [];
  private $storage;

  public function __construct()
  {
    $this->storage = new HandyBag();
  }
    
  public function storage()
  {
    return $this->storage;
  }

  public function factory(string $id, \Closure $closure)
  {
    $this->factories[$id] = $closure;
  }
    
  public function service(string $id, \Closure $closure) // был array $params = []
  {
    $this->services[$id] = $this->invoke($closure);
  }
    
  public function get(string $id)
  {
    if (empty($this->services[$id])) {
      throw new UnknownIdentifierException($id);
    }

    return $this->services[$id];
  }
    
  public function getFactory(string $id)
  {
    if (empty($this->factories[$id])) {
      throw new UnknownIdentifierException($id);
    }

    return $this->factories[$id];
  }
    
  public function fabricate(string $id, ...$params)
  {
    if (empty($this->factories[$id])) {
      throw new UnknownIdentifierException($id);
    }

    return $this->invoke($this->factories[$id], $params);
  }
    
  public function register(HandyBoxInterface $box)
  {
    $box->register($this);
  }
    
  protected function invoke(\Closure $closure, array $params = [])
  {
    return call_user_func_array($closure, $params);
  }
}