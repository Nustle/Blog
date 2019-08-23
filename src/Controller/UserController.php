<?php

namespace Blog\Controller;

use Blog\Core\Exception\ValidatorException;
use Blog\Forms\SignUp;
use Blog\Forms\SignIn;
use Blog\Core\Forms\FormBuilder;
use Blog\Core\Http\Cookie;

class UserController extends BaseController
{
  public function signUpAction() 
  {
    $this->title = 'Регистрация';

    $form = new SignUp();
    $formBuilder = new FormBuilder($form);

    $session = $this->container->get('http.session');

    if ($this->request->isPost()) {

      $user = $this->container->get('user');

      try {
        $user->signUp($form->handleRequest($this->request));

        $this->response
          ->redirect(ROOT)
          ->send();
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
      
      $user = $this->container->get('user');
      $handled = $form->handleRequest($this->request);

      try {
        $user->signIn($handled);

        $this->response
          ->redirect(ROOT)
          ->send();

        if (isset($handled['remember'])) {
          $session = $this->container->get('http.session');
          $cookie = new Cookie('sid', $session->collection()->get('sid'), strtotime('+30 days', time()));
          $this->response->setCookie($cookie);
        }
      } catch (ValidatorException $e) {
        $form->addErrors($e->getErrors());
      }
    }

    $this->content = $this->template('Sign-in', 'sign-in', ['form' => $formBuilder]);
  }
}