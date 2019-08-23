<?php

namespace Blog\Core\Http;

class Cookie
{
  public $name;
  public $value;
  public $expire;
  public $path;
  public $domain;

  public function __construct(
    string $name, 
    string $value = null, 
    $expire = 0, string $path = '/', 
    string $domain = null
  ) {

    $this->name = $name;
    $this->value = $value;

    if ($expire instanceof \DateTimeInterface) {
      $expire = $expire->format('U');
    } elseif (!is_numeric($expire)) {
      $expire = strtotime($expire);

      if (false === $expire) {
        throw new \InvalidArgumentException('The cookie expiration time is not valid.');
      }
    }

    $this->expire = $expire;
    $this->path = $path;
    $this->domain = $domain;
  }
}
