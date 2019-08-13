<?php

namespace Blog\Box;

use Blog\Core\HandyBox\HandyBoxInterface;
use Blog\Core\HandyBox\HandyBoxContainer;
use Blog\Core\Validator;

class ModelFactory implements HandyBoxInterface
{
  public function register(HandyBoxContainer $container)
  {
    $container->factory('factory.model', function ($name) use ($container) {
      $model = sprintf("model\%sModel", $name);

      return new $model(
        $container->get('db.driver'),
        new Validator()
      );
    });
  }
}