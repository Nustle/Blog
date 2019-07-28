<?php

namespace core;

use model\UserModel;
use model\SessionModel;
use core\Request;
use core\Exception\ValidatorException;


class User
{
  private $mUser;
  private $mSession;

  public function __construct(UserModel $mUser, SessionModel $mSession)
  {
    $this->mUser = $mUser;
    $this->mSession = $mSession;
  }

  public function signUp(array $fields)
  {
    if (!$this->comparePass($fields)) {
      throw new ValidatorException('Incorrect password given');
    }
    
    $this->mUser->signUp($fields);
  }

  public function signIn(array $fields)
  {
    $user = $this->mUser->getByLogin(htmlspecialchars(trim($fields['login'])));

    if (!$user) {
      throw new ValidatorException("User with login $user not found");
    }

    $matched = $this->mUser->getHash($fields['password']) === $user['password'];
    
    if (!$matched) {
      throw new ValidatorException('Access denied!');
    }

    $isAuth = $this->isAuth();

    if (!$isAuth) {
      throw new ValidatorException('You are not registrated user, please do this');
    }

    if (isset($fields['remember'])) {
      setcookie('login', hash('sha256', $user), time() + 3600 * 24 * 365, '/');
      setcookie('password', hash('sha256', $matched), time() + 3600 * 24 * 365, '/');
    }

    // Открываем обе сессии

    return true;
  }

  public function isAuth(Request $request = null)
  {
    // Нужно выдернуть пользователя из БД по SID
    if ($request->session('sid') && $this->mSession->getBySid('sid')) {
      $user = $this->mUser->getBySid('sid');
    } 


  }

  private function comparePass($fields)
  {
    return $this->mUser->getHash($fields['password']) === $this->mUser->getHash($fields['reply_password']);
  }
}