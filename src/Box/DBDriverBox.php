<?php

namespace Blog\Box;

use Blog\Core\HandyBox\HandyBoxInterface;
use Blog\Core\HandyBox\HandyBoxContainer;
use Blog\Core\DBDriver;
use Blog\Core\DBConnector;

class DBDriverBox implements HandyBoxInterface
{
  public function register(HandyBoxContainer $container)
  {
    $container->service('db.driver', function () {
      return new DBDriver(DBConnector::getConnect());
    });
  }
}