<?php

namespace Blog\Forms;

use Blog\Core\Forms\Form;

class SignIn extends Form
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
        'name' => 'remember',
        'type' => 'checkbox',
        'label' => ['text' => 'Запомнить меня'],
        'tag' => 'input'
      ],

      [
        'type' => 'submit',
        'value' => 'Войти',
        'tag' => 'input'
      ],

    ];

    $this->formName = 'sign-in';
    $this->method = 'POST';
  }
}