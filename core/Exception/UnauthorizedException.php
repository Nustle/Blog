<?php

namespace core\Exception;

class UnauthorizedException extends \Exception
{
  public function __construct()
  {
    parent::__construct();
  }
}