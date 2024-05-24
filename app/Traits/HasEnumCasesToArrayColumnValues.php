<?php

namespace App\Traits;

trait HasEnumCasesToArrayColumnValues
{
  public static function toArray(): array
  {
    return array_column(self::cases(), 'value');
  }
}
