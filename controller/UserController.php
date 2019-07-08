<?php

namespace controller;

use core\User;
use model\UserModel;
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

    if ($this->request->isPost()) {
      $mUser = new UserModel(
        new DBDriver(DBConnector::getConnect()),
        new Validator()
      );

      $user = new User($mUser); 

      try{
        $user->signUp($this->request->post());
        $this->redirect();
      } catch (UserException $e) {
        $errors = $e->getErrors();
      }
    }

    $this->content = $this->template('Sign-up', 'sign-up', ['errors' => $errors]);
  }

  public function signInAction()
  {
    $this->title = 'Авторизация';
    $errors = [];

    if ($this->request->isPost()) {
      $mUser = new UserModel(
        new DBDriver(DBConnector::getConnect()),
        new Validator()
      );
    }

    $this->content = $this->template('Sign-in', 'sign-in', ['errors' => $errors]);
  }
}