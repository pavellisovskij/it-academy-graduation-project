<?php

namespace app\controllers;

use app\core\Controller;
use app\core\View;
use app\core\Router;
use app\lib\Auth;
use app\lib\Flash;
use app\models\User;
use Rakit\Validation\Validator;

class UserController extends Controller
{
    public function index() {
        $user = new User();
        $user->insert([
            'username' => 'admin',
            'password_hash' => password_hash('Aaaaa1aa', PASSWORD_DEFAULT)
        ]);
    }

    public function signin() {
        $this->view->layout = 'text-center';
        $this->view->render('Штатное расписание. Вход.');
    }

    public function login() {
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $validator = new Validator;

            $validation = $validator->make($_POST, [
                'username' => 'required',
                'password' => 'required'
            ]);
            $validation->validate();

            if ($validation->fails()) {
                $errors = $validation->errors();
                Flash::set('auth_fail', $errors->all()[0]);
                Router::redirect('/signin');
            } else {
                $user = new User();
                $user = $user->select(['*'])->where('username', '=', $_POST['username'])->first()->get();

                if (password_verify($_POST['password'], $user['password_hash']) === true) {
                    Auth::setAuthorizedUser($user);
                    Router::redirect('/');
                }
                else {
                    Flash::set('auth_fail', 'Введены неверные учетные данные.');
                    Router::redirect('/signin');
                }
            }
        }
        else {
            Flash::set('auth_fail', 'Поля должны быть заполнены.');
            Router::redirect('/signin');
        }
    }

    public function logout() {
        if (Auth::check()) {
            Auth::unsetAuthorizedUser();
            Router::redirect('/');
        }
        else View::errorCode(403);
    }
}