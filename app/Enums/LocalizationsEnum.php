<?php

namespace App\Enums;

use App\Traits\HasEnumCasesToArrayColumnValues;

enum LocalizationsEnum: string
{
  use HasEnumCasesToArrayColumnValues;
  
  case ES = 'es';
  case EN = 'en';
}
