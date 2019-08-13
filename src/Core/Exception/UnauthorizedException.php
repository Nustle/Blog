<?php

namespace Blog\Core\Exception;

class UnauthorizedException extends \Exception
{
  public function __construct($message, \Exception $previus = null)
  {
    parent::__construct($message, 403, $previus);
  }
}