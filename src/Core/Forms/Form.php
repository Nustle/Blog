<?php

namespace Blog\Core\Forms;

use Blog\Core\Http\Request;

abstract class Form
{
  protected $formName;
  protected $action;
  protected $method;
  protected $fields;

  public function getName()
  {
    return $this->formName;
  }

  public function getAction()
  {
    return $this->action();
  }

  public function getMethod()
  {
    return $this->method;
  }

  public function getFields()
  {
    return new \ArrayIterator($this->fields);
  }

  public function handleRequest(Request $request)
  {
    $fields = [];

    foreach ($this->getFields() as $key => $field) {
      if (!isset($field['name'])) {
        continue;
      }

      $name = $field['name'];

      if ($request->post()->get($name) !== null) {

        if ($this->fields[$key]['type'] === 'checkbox') {
          $this->fields[$key]['checked'] = 'checked';
        }

        $this->setAttribute($key, 'value', $request->post()->get($name));
        $fields[$name] = $request->post()->get($name);
      }
    }

    if ($request->post()->get('sign') !== null && $this->getSign() !== $request->post()->get('sign')) {
      die('Формы не совпадают!');
    }

    return $fields;
  }

  public function setAttribute($key, $attrName, $attrValue)
  {
    $this->fields[$key][$attrName] = $attrValue;
  }

  public function getSign()
  {
    $string = '';
    foreach ($this->getFields() as $field) {
      if (isset($field['name'])) {
        $string .= '/#@=@/' . $field['name'];
      }
    }

    return hash('sha256', $string);
  }

  public function addErrors(array $errors)
  {
    foreach ($this->fields as $key => $field) {
      $name = $field['name'] ?? null;
      if (isset($errors[$name])) {
        $this->fields[$key]['errors'] = $errors[$name];
      }
    }
  }
}
