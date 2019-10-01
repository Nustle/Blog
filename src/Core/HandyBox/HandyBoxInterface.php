<?php

namespace Blog\Core\HandyBox;

interface HandyBoxInterface
{
  /**
   * Registers DI container
   *
   * @param HandyBoxContainer $container
   * @return void
   */
  public function register(HandyBoxContainer $container);
}