<?php

namespace Blog\Core;

use Blog\Models\UserModel;
use Blog\Models\SessionModel;
use Blog\Models\RoleModel;
use Blog\Core\Http\Session;
use Blog\Core\Http\Request;
use Blog\Core\Exception\ValidatorException;
use Blog\Core\Exception\UnauthorizedException;

class User
{
  private $mUser;
  private $mSession;
  private $mRole;
  private $session;

  public $current = null;

  public function __construct(UserModel $mUser, SessionModel $mSession, RoleModel $mRole, Session $session)
  {
    $this->mUser = $mUser;
    $this->mSession = $mSession;
    $this->mRole = $mRole;
    $this->session = $session;
  }

  public function signUp(array $fields)
  {
    if (!$this->comparePass($fields)) {
      $errors = [
        'password' => ['The fields do not match'],
        'password-reply' => ['The fields do not match']
      ];

      throw new ValidatorException($errors);
    }
    
    $this->mUser->signUp($fields);

    // Возможно код ниже нужно убрать или подебажить
    $user = $this->mUser->getByLogin(htmlspecialchars(trim($fields['login'])));
    $id = $user['id'];

    $this->mSession->set($this->mSession->getSid(), $id);
    $this->session->collection()->set('sid', $this->mSession->getSid());

    return $id;
  }

  public function signIn(array $fields)
  {
    $user = $this->mUser->getByLogin(htmlspecialchars(trim($fields['login'])));

    if (!$user) {
      throw new UnauthorizedException('Wrong login or password');
    }

    if ($this->mUser->getHash($fields['password']) !== $user['password']) {
      throw new UnauthorizedException('Wrong login or password');
    }

    $isUpd = false;

    if ($sid = $this->session->collection()->get('sid', false)) {
      $isUpd = $this->mSession->update($sid);
    }

    if (!$isUpd) {
      $this->mSession->set($this->mSession->getSid(), $user['id']);
      $this->session->collection()->set('sid', $this->mSession->getSid());
    }

    return true;
  }

  public function isAuth(Request $request)
  {
    if ($this->current) {
      return true;
    }

    if ($sid = $this->session->collection()->get('sid')) {
      $this->current = $this->mUser->getBySid($sid);
    }

    if ($this->current) {
      $this->mSession->update($sid);

      return true;
    }

    if ($sid = $request->cookie()->get('sid')) {
      $this->mSession->set($sid, $this->current['id']); // Нужно откуда-то взять этот $idUser, пока вообще 0 всего на уме, 
      // мб поставить в SessionModel $idUser по умолчанию null

      $this->session->collection()->set('sid', $sid);

      return true;
    }

    return false;
  }

  public function checkAccess(string $priv)
  {
    if (!$this->current) {
      return false;
    }

    return $this->mRole->checkPriv($priv, $this->current['id']);
  }

  private function comparePass($fields)
  {
    return $fields['password'] === $fields['password-reply'];
  }
}