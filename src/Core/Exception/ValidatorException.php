<?php

namespace Blog\Core\Exception;

class ValidatorException extends CoreException 
{
  private $errors;

  public function __construct($errors)
  {
    parent::__construct('Validator exception', 403);
    $this->errors = $errors;    
  }

  public function getErrors()
  {
    return $this->errors;
  }
}