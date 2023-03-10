<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
  public function pluck()
  {
    return Category::orderBy('name')->pluck('name', 'id');
  }
}
