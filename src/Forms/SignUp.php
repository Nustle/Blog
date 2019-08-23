<?php

namespace Blog\Forms;

use Blog\Core\Forms\Form;

class SignUp extends Form
{
  public function __construct()
  {
    $this->fields = [
      [
        'name' => 'login',
        'type' => 'text',
        'placeholder' => 'Введите логин',
        'class' => 'class-class',
        'tag' => 'input'
      ],

      [
        'name' => 'password',
        'type' => 'password',
        'placeholder' => 'Введите пароль',
        'tag' => 'input'
      ],

      [
        'name' => 'password-reply',
        'type' => 'password',
        'placeholder' => 'Повторите пароль',
        'tag' => 'input'
      ],

      [
        'type' => 'submit',
        'value' => 'Отправить',
        'tag' => 'input'
      ],

    ];

    $this->formName = 'sign-up';
    $this->method = 'POST';
  }
}