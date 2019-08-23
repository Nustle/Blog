<?php

namespace Blog\Core;

use Blog\Core\Exception\CoreException;

class Validator
{
  const STRING = 'string';
  const INTEGER = 'integer';
  const FLOAT = 'float';
  const TEXT = 'text';

  public $clean = [];
  public $errors = [];
  public $success = false;
  private $rules;

  public function execute(array $fields)
  {

    if (!$this->rules) {
      throw new CoreException('Rules for validation not found');
    }
  
    foreach ($this->rules as $name => $rules) {

      if (isset($rules['require'])) {
        if (!$this->isRequired($name, $fields)) {
          $this->errors[$name] = sprintf('Required fields');
        }
      }
      
      if (!isset($fields[$name]) && (!isset($rules['require']) || !$rules['require'])) {
        continue;
      }

      if (isset($rules['type'])) {
        switch ($rules['type']) {
          case self::STRING:
            if (!$this->isString($fields[$name])) {
              $this->errors[$name][] = sprintf('Fields must be a string');
            }
            break;
          case self::INTEGER:
            if (!$this->isInteger($fields[$name])) {
              $this->errors[$name][] = sprintf('Fields must be a integer');
            }
            break;
          case self::FLOAT:
            if (!$this->isFloat($fields[$name])) {
              $this->errors[$name][] = sprintf('Fields must be a float');
            }
            break;
          default:
            throw new CoreException('Undefined type for validation');
        }
      }

      if (isset($rules['length'])) {
        $valid = false;

        if (is_array($rules['length'])) {
          $valid = $this->lengthInRange($fields[$name], $rules['length']);
        } else {
          $valid = $this->length($fields[$name], $rules['length']);
        }

        if (!$valid) {
          $this->errors[$name][] = sprintf(
            'String must be shorter than %s and longer than %s',
            $rules['length'][1],
            $rules['length'][0]
          );
        }
      }

      if (empty($this->errors[$name])) {
        $this->clean[$name] = $fields[$name];
      }
    }

    if (empty($this->errors)) {
      $this->success = true;
    }
  }

  public function lengthInRange($str, array $range)
  {
    $maxMatch = $range[1] === self::TEXT ? true : strlen($str) <= (int)$range[1];
    $minMatch = strlen($str) >= (int)$range[0];

    return $maxMatch && $minMatch;
  }

  public function length($str, $length)
  {
    return strlen($str) <= $length;
  }

  public function isFloat($value)
  {
    $floatValue = floatval($value);
    return $floatValue && intval($value) !== $floatValue;
  }

  public function isInteger($value)
  {
    return ctype_digit($value) || is_int($value);
  }

  public function isString($value)
  {
    return is_string($value);
  }

  public function isRequired($name, array $fields)
  {
    return isset($fields[$name]);
  }

  public function setRules(array $rules)
  {
    $this->rules = $rules;
  }
}