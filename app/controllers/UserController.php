<?php

namespace app\controllers;

use app\core\Controller;
use app\core\View;
use app\lib\Flash;
use app\models\User;
use Sirius\Validation\Validator;
use app\lib\PasswordRule;

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
            $validator = new Validator();
            $validator->add([
                'username:Username' => 'required | minlength(4) | maxlength(16) | alpha',
                'password:Password' => 'required | minlength(4) | maxlength(16) | app\lib\PasswordRule',
            ]);

//            $validator->add('username', 'required', null, 'Имя пользователя обязательно для ввода.')
//                ->add('username', 'minlength(4)', null, 'Имя пользователя должно содержать минимум 4 символа.')
//                ->add('username', 'maxlength(16)', null, 'Имя пользователя должно содержать максимум 16 символов.')
//                ->add('username', 'alpha', null, 'Имя пользователя должно содержать только буквы латинского алфавита')
//                ->add('password', 'required', null, 'Пароль обязателен для заполнения.')
//                ->add('password', 'minlength(4)', null, 'Пароль должен содержать минимум 4 символа.')
//                ->add('password', 'maxlength(16)', null, 'Пароль должен содержать максимум 16 символов.')
//                ->add('password', 'app\lib\PasswordRule');
//            $data = [
//                'username' => $_POST['username'],
//                'password' => $_POST['password']
//            ];

            $errors = $validator->validate($_POST);

            if ($errors === false) {
                $this->view->layout = 'text-center';
                $this->view->path = '/user/signin';
                $this->view->render('Штатное расписание. Вход.', [
                    'validator' => $validator,
                    'errors'    => $errors
                ]);
            }
            else {
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