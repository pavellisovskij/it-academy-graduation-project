<?php

namespace app\controllers;

use app\core\Controller;
use app\models\User;

class UserController extends Controller
{
    public function index() {
        $user = new User();
        $user->insert([
            'username' => 'admin',
            'password_hash' => password_hash('1234', PASSWORD_DEFAULT)
        ]);
    }

    public function signin() {
        $this->view->layout = 'text-center';
        $this->view->render('Штатное расписание. Вход.');
    }

    public function login() {
        if (!empty($_POST) && isset($_POST['username'])) {
            $user = new User();
            $user->verify($_POST['username'], $_POST['password']);
        }
    }
}