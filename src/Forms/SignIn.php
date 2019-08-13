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
        'class' => 'class-class'
      ],

      [
        'name' => 'password',
        'type' => 'password',
        'placeholder' => 'Введите пароль'
      ],

      [
        'name' => 'remember',
        'type' => 'checkbox',
        'label' => ['text' => 'Запомнить меня']
      ],

      [
        'type' => 'submit',
        'value' => 'Войти'
      ],

    ];

    $this->formName = 'sign-in';
    $this->method = 'POST';
  }
}