<?php

namespace Blog\Core\Forms;

class FormBuilder
{
  public $form;

  public function __construct(Form &$form)
  {
    $this->form = $form;
  }

  public function method()
  {
    $method = $this->form->getMethod();

    if ($method === null) {
      $method = 'GET';
    }

    return sprintf('method="%s"', $method);
  }

  public function fields()
  {
    foreach ($this->form->getFields() as $field) {
    
      if ($field['tag'] === 'input') {
        $inputs[] = $this->input($field);
      } else {
        $inputs[] = $this->textarea($field);
      }
    }

    return $inputs;
  }

  public function input(array $attributes)
  {
    $errors = '';
    $label = null;

    if (isset($attributes['errors'])) {
      $errors = $this->getErrors($attributes);
    }

    if (isset($attributes['label'])) {
      $label = $attributes['label'];
      unset($attributes['label']);
    }

    $input = sprintf('<input %s>%s', $this->buildAttributes($attributes), $errors);

    if ($label) {
      $input = sprintf('<label>%s%s</label>', $input, $label['text']);
    }

    return $input;
  }

  public function textarea(array $attributes)
  {
    $errors = '';
    $label = null;

    if (isset($attributes['errors'])) {
      $errors = $this->getErrors($attributes);
    }

    if (isset($attributes['label'])) {
      $label = $attributes['label'];
      unset($attributes['label']);
    }

    $textarea = sprintf('<textarea %s></textarea>%s', $this->buildAttributes($attributes), $errors);

    if ($label) {
      $textarea = sprintf('<label>%s%s</label>', $textarea, $label['text']);
    }

    return $textarea;
  }

  public function inputSign()
  {
    return $this->input([
      'type' => 'hidden',
      'name' => 'sign',
      'value' => $this->form->getSign()
    ]);
  }

  private function buildAttributes(array $attributes)
  {
    if (isset($attributes['tag'])) {
      unset($attributes['tag']);
    }

    $arr = [];
    foreach ($attributes as $attribute => $value) {
      $arr[] = sprintf('%s="%s"', $attribute, $value);
    }

    return implode(' ', $arr);
  }

  private function getErrors(array &$attributes)
  {
    $class = $attributes['class'] ?? '';
    $attributes['class'] = trim(sprintf('%s error', $class));
    $errors = $attributes['errors'];

    unset($attributes['errors']);

    return '<div>' . implode('</div><div>', $errors) . '</div>';
  }
}
