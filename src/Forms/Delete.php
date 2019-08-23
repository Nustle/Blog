<?php

namespace Blog\Forms;

use Blog\Core\Forms\Form;

class Delete extends Form
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
        'type' => 'submit',
        'value' => 'Удалить',
        'tag' => 'input'
      ],

    ];

    $this->formName = 'delete';
    $this->method = 'POST';
  }
}
