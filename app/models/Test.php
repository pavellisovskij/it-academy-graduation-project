<?php

namespace app\models;

use app\core\Model;

class Test extends Model
{
    public $table_name = 'test';
    
    public function getSql() {
        return $this->sql;
    }
}