<?php

namespace Blog\Core;

use Blog\Models\UserModel;
use Blog\Models\SessionModel;
use Blog\Core\Request;
use Blog\Core\Exception\ValidatorException;

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
      return false;
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
    return $fields['password'] === $fields['password-reply'];
  }
}