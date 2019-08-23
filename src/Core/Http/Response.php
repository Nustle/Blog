<?php

namespace Blog\Core\Http;

use Blog\Core\HandyBox\HandyBag;
use Blog\Core\Http\Cookie;

class Response
{
  const HTTP_OK = 200;
  const HTTP_MOVED_PERMANENTLY = 301;
  const HTTP_FOUND = 302;
  const HTTP_BAD_REQUEST = 400;
  const HTTP_UNAUTHORIZED = 401;
  const HTTP_PAYMENT_REQUIRED = 402;
  const HTTP_FORBIDDEN = 403;
  const HTTP_NOT_FOUND = 404;
  const HTTP_METHOD_NOT_ALLOWED = 405;
  const HTTP_INTERNAL_SERVER_ERROR = 500;
  const HTTP_NOT_IMPLEMENTED = 501;
  const HTTP_BAD_GATEWAY = 502;
  const HTTP_SERVICE_UNAVAILABLE = 503;
  const HTTP_GATEWAY_TIMEOUT = 504;

  public static $statusTexts = [
    self::HTTP_OK => 'OK',
    self::HTTP_MOVED_PERMANENTLY => 'Moved Permanently',
    self::HTTP_FOUND => 'Found',
    self::HTTP_BAD_REQUEST => 'Bad Request',
    self::HTTP_UNAUTHORIZED => 'Unauthorized',
    self::HTTP_PAYMENT_REQUIRED => 'Payment Required',
    self::HTTP_FORBIDDEN => 'Forbidden',
    self::HTTP_NOT_FOUND => 'Not Found',
    self::HTTP_METHOD_NOT_ALLOWED => 'Method Not Allowed',
    self::HTTP_INTERNAL_SERVER_ERROR => 'Internal Server Error',
    self::HTTP_NOT_IMPLEMENTED => 'Not Implemented',
    self::HTTP_BAD_GATEWAY => 'Bad Gateway',
    self::HTTP_SERVICE_UNAVAILABLE => 'Service Unavailable',
    self::HTTP_GATEWAY_TIMEOUT => 'Gateway Timeout',
  ];

  protected $headers;
  protected $content;
  protected $statusCode;
  protected $statusText;

  public function __construct(string $content = '', int $status = 200, array $headers = [])
  {
    $this->headers = new HandyBag($headers);
    $this->setContent($content);
    $this->setStatus($status);
  }

  public function headers()
  {
    return $this->headers;
  }

  public function setContent($content)
  {
    $this->content = $content;

    return $this;
  }

  public function setStatus(int $code, string $text = null)
  {
    $this->statusCode = $code;

    if ($this->isInvalid()) {
      throw new \InvalidArgumentException(sprintf('The HTTP status "%s" is not valid', $code));
    }

    if ($text === null) {
      $this->statusText = isset(self::$statusTexts[$code]) ? self::$statusTexts[$code] : 'Unknown status';

      return $this;
    }

    if ($text === false) {
      $this->statusText = '';

      return $this;
    }

    $this->statusText = $text;

    return $this;
  }

  public function redirect(string $url)
  {
    $this->headers->set('redirect', sprintf('Location: %s', $url));
    $this->setStatus(self::HTTP_MOVED_PERMANENTLY);

    return $this;
  }

  public function setCookie(Cookie $cookie)
  {
    setcookie($cookie->name, $cookie->value, $cookie->expire, $cookie->path, $cookie->domain);

    return $this;
  }

  public function sendHeaders()
  {
    if ($this->headers->count() === 0) {
      return $this;
    }

    if (headers_sent()) {
      return $this;
    }

    foreach ($this->headers->getAll() as $header) {
      header($header);
    }

    header('HTTP/1.1 %s %s', $this->statusCode, $this->statusText);

    return $this;
  }

  public function sendContent()
  {
    echo $this->content;

    return $this;
  }

  public function send()
  {
    $this->sendHeaders();
    $this->sendContent();

    return $this;
  }

  public function isInvalid()
  {
    return $this->statusCode < 100 || $this->statusCode >= 600;
  }

}