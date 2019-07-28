<?php

namespace core\Exception;

class ModelException extends \Exception
{
  private $errors;

  public function __construct(array $errors)
  {
    parent::__construct();
    $this->errros = $errors;
  }

  public function getErrors()
  {
    return $this->errors;
  }
}
