<?php

namespace Blog\Controller;

use Blog\Core\Http\Request;
use Blog\Core\Http\Response;
use Blog\Core\HandyBox\HandyBoxContainer;

class BaseController
{
  protected $title;
  protected $content;
  protected $session;

  protected $request;
  protected $response;
  protected $container;

  public function __construct(Request $request = null, Response $response = null, HandyBoxContainer $container = null)
  {
    $this->title = 'Главная';
    $this->content = '';

    $this->request = $request;
    $this->response = $response;
    $this->container = $container;
  }

  public function render()
  {
    echo $this->template(
        'Index', 'main',
        [
          'title' => $this->title,
          'content' => $this->content
        ]
      );
  }

  protected function template($filepart, $filename, array $params = [])
  {
    ob_start();
    extract($params);
    include_once __DIR__ . "/../Views/$filepart/$filename.php";
    return ob_get_clean();
  }
}