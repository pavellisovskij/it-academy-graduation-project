<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Router;
use app\lib\Auth;
use app\lib\Flash;
use app\lib\Paginator;
use app\models\Position;
use app\models\User;
use Rakit\Validation\Validator;

class PositionController extends Controller
{
    public function index($page = 1) {
        $position          = new Position();
        $numberOfPositions = (int) $position->count();
        $positionsPerPage  = 10;
        $pages             = (int) ceil($numberOfPositions / $positionsPerPage);

        if ($page === 1) $offset = 0;
        else $offset = $page * $positionsPerPage;

        $positions = $position->all()
            ->orderBy([['name', 'ASC']])
            ->take($positionsPerPage, $offset)
            ->get();

        $paginator = new Paginator($pages, $page, 2, '../positions/page/');

        $this->view->render('Должности', [
            'positions' => $positions,
            'paginator' => $paginator
        ]);
    }

    public function create() {
        if (Auth::check()) $this->view->render('Новая должность');
        else Router::redirect('/signin');
    }

    public function store() {
        if (Auth::check()) {
            $validator = new Validator();

            $validation = $validator->make($_POST, [
                'name'          => 'required|max:50|min:4',
                'position_code' => 'required|max:8|min:8|regex:/^[0-9]{4}-[0-9]{3}$/'
            ]);
            $validation->validate();

            if ($validation->fails()) {
                $errors = $validation->errors();

                foreach ($errors->firstOfAll() as $field => $message) {
                    Flash::set($field, $message);
                }

                Router::redirect('/position/create');
            }
            else {
                $position = new Position();
                $position = $position->insert([
                    'name'          => $_POST['name'],
                    'position_code' => $_POST['position_code']
                ]);

                Router::redirect('/positions');
            }
        }
        else Router::redirect('/signin');
    }

    public function delete($id) {
        if (Auth::check()) {
            $position = new Position();
            $result = $position->delete([$id]);

            Router::redirect('/positions');
        }
        else Router::redirect('/signin');
    }
}