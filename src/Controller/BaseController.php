<?php

namespace Blog\Controller;

use Blog\Core\Request;
use Blog\Core\Exception\ErrorNotFoundException;

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

  public function errorHandler($message, $trace)
  {
    $this->title = 'Error';
    $this->content = $this->template(
      'Error', 'error', 
      [
        'message' => $message,
        'trace' => $trace
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

  protected function redirect()
  {
    header('HTTP/1.0 403 Forbidden');
    header("Location: " . ROOT);
    exit();
  }

  protected function transfer(array $errors)
  {
    return implode("<br>", $errors);
  }
}