<?php

namespace core;

use core\Exception\ValidatorException;

class Validator
{
  const STRING = 'string';
  const INT = 'integer';
  const TEXT = 'text';

  public $clean = [];
  public $errors = [];
  public $success = false;
  private $rules = [];

  public function execute(array $fields)
  {

    if (!$this->rules) {
      throw new ValidatorException('Rules for validation not found');
    }
  
    foreach ($this->rules as $name => $rule) {

      if (!isset($fields[$name]) && isset($this->rules['require'])) {
        $this->errors[$name][] = sprintf('Field "%s" is require!', $name);
      }
      
      if (!isset($fields[$name]) && (!isset($this->rules['require']) || !$this->rules['require'])) {
        continue;
      }

      if (isset($this->rules['type']) && !$this->isTypeMatch($fields[$name], $this->rules['type'])) {
        $this->errors[$name][] = sprintf('Field "%s" must be a %s type', $name, $this->rules['type']);
      }

      if (isset($this->rules['length']) && !$this->isLengthMatch($fields[$name], $this->rules['length'])) {
        $this->errors[$name][] = sprintf('Field "%s" has an incorrect length', $name);
      }

      if (isset($this->rules['not_blank']) && $this->isBlank($fields[$name])) {
        $this->errors[$name][] = sprintf('Field %s is not blank', $name);
      }

      if (empty($this->errors[$name])) {
        if (isset($this->rules['type']) && $this->rules['type'] === self::STRING) {
            $this->clean[$name] = htmlspecialchars(trim($fields[$name]));
        } elseif (isset($this->rules['type']) && $this->rules['type'] === self::INT) {
            $this->clean[$name] = (int)$fields[$name];
        } else {
          $this->clean[$name] = $fields[$name];
        }
      }
    }

    if (empty($this->errors)) {
      $success = true;
    }
  }

  public function setRules(array $rules)
  {
    $this->rules = $rules;
  }

  public function isTypeMatch($field, $type)
  {
    switch ($type) {
      case 'string':
        return is_string($field);
        break;
      case 'int':
        return gettype($field) === self::INT || ctype_digit($field);
        break;
      default:
        throw new ValidatorException('Incorrect type given for method "isTypeMatch"');
        break;
    }
  }

  public function isLengthMatch ($field, $length)
  {
    if ($isArray = is_array($length)) {
        $min = isset($length[0]) ? $length[0] : false;
        $max = isset($length[1]) ? $length[1] : false;
    } elseif (!$isArray && $length === self::TEXT) {
        $min = false; 
        $max = is_string($length) ? $length : false;
    } 
    else{
        $min = false;
        $max = $length;
    }

    if ($isArray && (!$min || !$max)) {
      throw new ValidatorException('Incorrect value given for method "isLengthMatch"');
    }

    if (!$isArray && !$max) {
      throw new ValidatorException('Incorrect value given for method "isLengthMatch"');
    }

    $minIsMatch = $min ? $this->isLengthMinMatch($field, $min) : false;
    $maxIsMatch = $max ? $this->isLengthMaxMatch($field, $max) : false;

    return $isArray ? $minIsMatch && $maxIsMatch : $maxIsMatch;
  }

  private function isLengthMinMatch($field, $length)
  {
    return mb_strlen($field) < $length === false;
  }

  private function isLengthMaxMatch($field, $length)
  {
    return mb_strlen($field) > $length === false;
  }

  public function isBlank($field)
  {
    $field = trim($field);
    return $field === null || $field === '';
  }
}