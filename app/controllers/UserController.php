<?php

namespace app\controllers;

use app\core\Controller;
use app\core\View;
use app\lib\Flash;
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
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $user = new User();
            $user = $user->select(['*'])->where('username', '=', $_POST['username'])->first()->get();

            if (password_verify($_POST['password'], $user['password_hash']) === true) {
                $_SESSION['username'] = $_POST['username'];
                $this->view->redirect('/workplaces');
            }
            else {
                Flash::set('auth_fail', 'Введены неверные учетные данные.');
                $this->view->redirect('/signin');
            }
        }
        else {
            Flash::set('auth_fail', 'Введены неверные учетные данные.');
            $this->view->redirect('/signin');
        }
    }

    public function logout() {
        if (User::isAdmin()) {
            unset($_SESSION['username']);
            $this->view->redirect('/workplaces');
        }
        else View::errorCode(403);
    }
}