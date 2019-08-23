<?php

namespace Blog\Controller;

class PageController extends BaseController
{
  public function errorAction(\Exception $e)
  {
    $this->title = 'Ошибка';

    $this->content = $this->template(
      'Error', 'error',
      [
        'errorMessage' => $e->getMessage(),
        'errorStackTrace' => $e->getTraceAsString(),
        'dev' => false
      ]
    );
  }
}