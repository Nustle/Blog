<?php

namespace Blog\Core\Http;

use Blog\Core\HandyBox\HandyBag;

class Session
{
  protected $bag;

  protected $isStarted = false;

  public function __construct()
  {
    $this->bag = new HandyBag();
  }

  public function start()
  {
    if (!session_start()) {
      throw new \RuntimeException('Session start is failed.');
    }

    $this->isStarted = true;

    return $this;
  }

  public function collection()
  {
    return $this->bag;
  }

  public function initialize()
  {
    if (!$this->isStarted) {
      return $this;
    }

    $this->bag->merge($_SESSION);

    return $this;
  }

  public function getId()
  {
    if ($this->isStarted === false) {
      return false;
    }

    return session_id();
  }

  public function save()
  {
    if ($this->bag->count() === 0) {
      return $this;
    }

    if ($this->isStarted === false) {
      return $this;
    }

    foreach ($this->bag->getAll as $key => $value) {
      $_SESSION[$key] = $value;
    }

    return $this;
  }
}