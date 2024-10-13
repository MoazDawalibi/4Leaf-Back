<?php

namespace App\Services;

use App\Models\StaticInfo;
use App\Services\Base\BaseService;

class StaticInfoService extends BaseService
{   
    public $columnSearch = "key";
    public function __construct()
    {
        parent::__construct(StaticInfo::class);
    }
}
