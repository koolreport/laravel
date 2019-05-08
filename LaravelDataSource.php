<?php

namespace koolreport\laravel;

use Illuminate\Support\Facades\DB;
use \koolreport\datasources\PdoDataSource;
use \koolreport\core\Utility;

class LaravelDataSource extends PdoDataSource
{
    protected function onInit()
    {
        $name = Utility::get($this->params,"name");
        $this->connection = DB::connection($name)->getPdo();
    }
}