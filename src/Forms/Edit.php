<?php

namespace Blog\Forms;

use Blog\Core\Forms\Form; 

class Edit extends Form
{
  public function __construct()
  {
    $this->fields = [
      [
        'name' => 'title',
        'type' => 'text',
        'placeholder' => 'Новое название статьи',
        'class' => 'class-class',
        'tag' => 'input'
      ],

      [
        'name' => 'content',
        'placeholder' => 'Текст статьи',
        'tag' => 'textarea'
      ],

      [
        'type' => 'submit',
        'value' => 'Сохранить',
        'tag' => 'input'
      ],

    ];

    $this->formName = 'edit';
    $this->method = 'POST';
  }
}