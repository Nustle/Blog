<?php

namespace Blog\Controller;

use Blog\Core\User;
use Blog\Models\UserModel;
use Blog\Models\SessionModel;
use Blog\Core\Exception\ValidatorException;
use Blog\Core\DBconnector;
use Blog\Core\DBDriver;
use Blog\Core\Validator;
use Blog\Forms\SignUp;
use Blog\Forms\SignIn;
use Blog\Core\Forms\FormBuilder;
use Blog\Core\HandyBox\HandyBoxContainer;
use Blog\Box\UserBox;
use Blog\Box\ModelFactory;

class UserController extends BaseController
{
  public function signUpAction() 
  {
    $this->title = 'Регистрация';

    $form = new SignUp();
    $formBuilder = new FormBuilder($form);

    $container = new HandyBoxContainer();
    /*var_dump($container);
    die;*/

    if ($this->request->isPost()) {
      $container->register(new ModelFactory());
      $container->fabricate('factory.model', 'User');

      $container->register(new ModelFactory());
      $container->fabricate('factory.model', 'Session');

      $container->register(new UserBox());
      $user = $container->get('user');

      try {
        $user->signUp($form->handleRequest($this->request));
        $this->redirect();
      } catch (ValidatorException $e) {
        $form->addErrors($e->getErrors());
      }
    }

    $this->content = $this->template('Sign-up', 'sign-up', ['form' => $formBuilder]);
  }

  public function signInAction()
  {
    $this->title = 'Войти';

    $form = new SignIn();
    $formBuilder = new FormBuilder($form);

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
        $user->signIn($form->handleRequest($this->request));
        $this->redirect();
      } catch (ValidatorException $e) {
        $form->addErrors($e->getErrors());
      }
    }

    $this->content = $this->template('Sign-in', 'sign-in', ['form' => $formBuilder]);
  }
}