<?php

namespace controller;

use core\Request;
use core\Exception\ErrorNotFoundException;

class BaseController
{
  protected $title;
  protected $content;
  protected $request;

  public function __construct(Request $request = null)
  {
    $this->request = $request;
    $this->title = 'Главная';
    $this->content = '';
  }

  public function __call($name, $arguments)
  {
    throw new ErrorNotFoundException();
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

  public function errrorHandler($message, $trace)
  {
    $this->title = 'Error';
    $this->content = $this->template(
      'Error', 'error', 
      [
        'message' => $this->message,
        'trace' => $this->trace
      ]
    );
  }

  protected function template($filepart, $filename, array $params = [])
  {
    ob_start();
    extract($params);
    include_once __DIR__ . "/../view/$filepart/$filename.php";
    return ob_get_clean();
  }

  protected function redirect()
  {
    header('HTTP/1.0 403 Forbidden');
    header("Location: " . ROOT);
    exit();
  }
}