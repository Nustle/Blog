<?php

namespace Blog\Core\Exception;

class UnknownIdentifierException extends \InvalidArgumentException
{
  public function __construct($id)
  {
    parent::__construct(sprintf('Box with identifier "%s" is not defined in container.', $id));
  }
}
