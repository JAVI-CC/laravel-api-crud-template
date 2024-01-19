<?php

namespace App\Services;


class StrService
{
  //Para evitar datos duplicados
  public static function preventNamesDuplicates(string $name): string
  {
    strlen($name) < 240 ?: $name = substr($name, 0, -15);
    return time() . '::' . $name;
  }
}
