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
        'class' => 'class-class'
      ],

      [
        'name' => 'password',
        'type' => 'password',
        'placeholder' => 'Введите пароль'
      ],

      [
        'name' => 'password-reply',
        'type' => 'password',
        'placeholder' => 'Повторите пароль'
      ],

      [
        'type' => 'submit',
        'value' => 'Отправить'
      ],

    ];

    $this->formName = 'sign-up';
    $this->method = 'POST';
  }
}