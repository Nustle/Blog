<?php

namespace Blog;

use Blog\Core\Http\Request;
use Blog\Core\Http\Response;
use Blog\Core\Http\Session;
use Blog\Controller\BaseController;
use Blog\Controller\PageController;
use Blog\Core\HandyBox\HandyBoxContainer;
use Symfony\Component\Dotenv\Dotenv;

class Application
{
  public $currentController;
  public $currentAction;
  protected $container;
  protected $request;
  protected $response;

  public function __construct(HandyBoxContainer $container = null)
  {
    $this->enableErrorsHandling();
    $this->loadDotEnv();

    $this->container = null === $container ? new Container() : $container;

    $this->response = new Response();
    $this->requestInit();
    $this->parseUrl();
  }

  public function run()
  {
    $session = $this->container->get('http.session');
    $session
      ->start()
      ->initialize();

    $controller = new $this->currentController($this->request, $this->response, $this->container);
    $action = $this->currentAction;

    $controller->$action();

    $session->save();

    $this->response->setContent($controller->render());
    $this->response->send();
  }

  protected function parseUrl()
  {
    $uri = $this->request->server()->get('REQUEST_URI');

    $uriParts = explode('/', $uri);

    unset($uriParts[0], $uriParts[1], $uriParts[2], $uriParts[3]);
    $uriParts = array_values($uriParts);

    $controller = isset($uriParts[0]) && $uriParts[0] !== '' ? ucfirst($uriParts[0]) : 'Home';
    $this->currentController = sprintf('Blog\Controller\%sController', $controller);

    $id = null;
    if (isset($uriParts[1]) && is_numeric($uriParts[1])) {
      $id = $uriParts[1];
      $uriParts[1] = 'post';
    }

    $action = isset($uriParts[1]) && $uriParts[1] !== '' && is_string($uriParts[1]) ? $uriParts[1] : 'index';

    $actionParts = explode('-', $action);
    for ($i = 1; $i < count($actionParts); $i++) {
      if (!isset($actionParts[$i])) {
        continue;
      }

      $actionParts[$i] = ucfirst($actionParts[$i]);
    }

    $action = implode('', $actionParts);
    $this->currentAction = sprintf('%sAction', $action);

    if ($id === null) {
      $id = isset($uriParts[2]) && is_numeric($uriParts[2]) ? $uriParts[2] : false;
    }

    if ($id) {
      $this->request->get()->set('id', $id);
    }
  }

  protected function requestInit()
  {
    $this->request = new Request($_GET, $_POST, $_SERVER, $_COOKIE, $_FILES);
  }

  protected function loadDotEnv()
  {
    $dotenv = new Dotenv();
    $dotenv->load(__DIR__ . '/../.env');
  }

  public function enableErrorsHandling()
  {
    set_exception_handler(function ($e) {
      $controller = new PageController($this->request, $this->response, $this->container);
      $controller->errorAction($e);

      $this->response->setContent($controller->render());
      $this->response->send();
    });
  }
}