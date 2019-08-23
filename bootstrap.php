<?php

require_once __DIR__ . '/vendor/autoload.php';

use Blog\Core\HandyBox\HandyBoxContainer;
use Blog\Box\DBDriverBox;
use Blog\Box\ModelFactory;
use Blog\Box\UserBox;
use Blog\Box\SessionBox;
use Blog\Application;

$container = new HandyBoxContainer();
$app = new Application($container);

$container->register(new DBDriverBox());
$container->register(new ModelFactory());
$container->register(new UserBox());
$container->register(new SessionBox());

return $app;