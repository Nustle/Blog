<?php

namespace Blog\Core;

class Request
{
  const METHOD_POST = 'POST';
  const METHOD_GET = 'GET';

  private $get;
  private $post;
  private $server;
  private $cookie;
  private $files;
  private $session;

  public function __construct($get, $post, $server, $cookie, $files, $session)
  {
    $this->get = $get;
    $this->post = $post;
    $this->server = $server;
    $this->cookie = $cookie;
    $this->files = $files;
    $this->session = $session;
  }

  public function get($key = null)
  {
    return $this->request($this->get, $key);
  }

  public function post($key = null)
  {
    return $this->request($this->post, $key);
  }

  public function session($key = null)
  {
    return $this->request($this->session, $key);
  }

  public function isGet()
  {
    return $this->server['REQUEST_METHOD'] === self::METHOD_GET;
  }

  public function isPost()
  {
    return $this->server['REQUEST_METHOD'] === self::METHOD_POST;
  }

  private function request(array $arr, $key = null)
  {
    if (!$key) {
      return $arr;
    }

    if (isset($arr[$key])) {
      return $arr[$key];
    }

    return null;
  } 
}
