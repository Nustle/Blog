<?php

namespace Blog\Forms;

use Blog\Core\Forms\Form; 

class Add extends Form
{
  public function __construct()
  {
    $this->fields = [
      [
        'name' => 'title',
        'type' => 'text',
        'placeholder' => 'Название статьи',
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
        'value' => 'Отправить',
        'tag' => 'input'
      ],

    ];

    $this->formName = 'add';
    $this->method = 'POST';
  }
}