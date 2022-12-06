<?php

namespace Bcampti\Larabase\Commands\Traits;

use Illuminate\Support\Str; 

trait Settings
{
    public function tablePrefix(){
        return config("larabase.table_prefix");
    }

    public function getTableName( $model ){
        return $this->tablePrefix().Str::snake(class_basename($model));
    }
}