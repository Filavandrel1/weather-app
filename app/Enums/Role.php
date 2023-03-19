<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

enum Role: string
{
  case User = 'user';
  case Admin = 'admin';
}
