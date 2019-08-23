<?php

namespace Blog\Box;

use Blog\Core\HandyBox\HandyBoxInterface;
use Blog\Core\HandyBox\HandyBoxContainer;
use Blog\Core\Http\Session;

class SessionBox implements HandyBoxInterface
{
  public function register(HandyBoxContainer $container)
  {
    $container->service('http.session', function () {
      return new Session();
    });
  }
}