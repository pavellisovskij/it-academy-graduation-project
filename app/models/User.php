<?php

namespace app\models;

use app\core\Model;

class User extends Model
{
    protected $table_name = 'users';

    public static function isAdmin() {
        if (isset($_SESSION['username']) && $_SESSION['username'] === 'admin') return true;
        else return false;
    }
}