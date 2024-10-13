<?php

namespace App\Services;

use App\Models\Category;
use App\Services\Base\BaseService;

class CategoryService extends BaseService
{
    public function __construct()
    {
        parent::__construct(Category::class);
    }
}
