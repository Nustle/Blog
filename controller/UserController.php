<?php

namespace controller;

use core\User;
use model\UserModel;
use model\SessionModel;
use core\Exception\UserException;
use core\DBconnector;
use core\DBDriver;
use core\Validator;

class UserController extends BaseController
{
  public function signUpAction() 
  {
    $this->title = 'Регистрация';
    $errors = [];
    $trouble = '';

    if ($this->request->isPost()) {
      $mUser = new UserModel(
        new DBDriver(DBConnector::getConnect()),
        new Validator()
      );

      $mSession = new SessionModel(
        new DBDriver(DBConnector::getConnect()),
        new Validator()
      );

      $user = new User($mUser, $mSession); 

      try {
        $user->signUp($this->request->post());
        $this->redirect();
      } catch (UserException $e) {
        $errors = $e->getErrors();
      }
    }

    $this->content = $this->template('Sign-up', 'sign-up', ['errors' => $this->transfer($errors), 'trouble' => $trouble]);
  }

  public function signInAction()
  {
    $this->title = 'Войти';
    $errors = [];

    if ($this->request->isPost()) {
      $mUser = new UserModel(
        new DBDriver(DBConnector::getConnect()),
        new Validator()
      );

      $mSession = new SessionModel(
        new DBDriver(DBConnector::getConnect()),
        new Validator()
      );

      $user = new User($mUser, $mSession);
      $user->signIn($this->request->post());
      $this->redirect();
    }

    $this->content = $this->template('Sign-in', 'sign-in', ['errors' => $this->transfer($errors)]);
  }
}