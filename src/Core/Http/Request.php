<?php

namespace Blog\Core\Http;

use Blog\Core\HandyBox\HandyBag;

class Request
{
  const METHOD_POST = 'POST';
  const METHOD_GET = 'GET';

  private $get;
  private $post;
  private $server;
  private $cookie;
  private $files;

  public function __construct($get, $post, $server, $cookie, $files)
  {
    $this->get = new HandyBag($get);
    $this->post = new HandyBag($post);
    $this->server = new HandyBag($server);
    $this->cookie = new HandyBag($cookie);
    $this->files = new HandyBag($files);
  }

  public function get()
  {
    return $this->get;
  }

  public function post()
  {
    return $this->post;
  }

  public function server()
  {
    return $this->server;
  }

  public function cookie()
  {
    return $this->cookie;
  }

  public function isGet()
  {
    return $this->server['REQUEST_METHOD'] === self::METHOD_GET;
  }

  public function isPost()
  {
    return $this->server['REQUEST_METHOD'] === self::METHOD_POST;
  }
}
