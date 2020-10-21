<?php

namespace app\models;

use app\core\Model;
use app\core\View;
use app\lib\Flash;

class User extends Model
{
    protected $table_name = 'users';

    public function verify(string $username, string $password) {
        $user = $this->select(['*'])
            ->where('username', '=', 'a')
            ->first()
            ->get();

        if ($user === false) {
            Flash::set('wrong_username', 'Пользователя с таким именем не существует');
            return false;
        }
        else {
            if (password_verify($password, $user['password_hash'])) return true;
            else return false;
        }
    }
}