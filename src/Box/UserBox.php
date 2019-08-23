<?php

namespace Blog\Box;

use Blog\Core\HandyBox\HandyBoxInterface;
use Blog\Core\HandyBox\HandyBoxContainer;
use Blog\Core\User;

class UserBox implements HandyBoxInterface
{
  public function register(HandyBoxContainer $container)
  {
    $container->service('user', function () use ($container) {
      return new User(
        $container->fabricate('factory.model', 'User'),
        $container->fabricate('factory.model', 'Session'),
        $container->fabricate('factory.model', 'Role'),
        $container->get('http.session')
      );
    });
  }
}