<?php

namespace app\controllers;

use app\core\Controller;
use app\lib\Paginator;
use app\models\Position;

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
        $this->view->render('Новая должность');
    }

    public function store() {
        if (!empty($_POST) && isset($_POST['name'])) {
            $position = new Position();
            $position = $position->insert([
                'name'          => $_POST['name'],
                'position_code' => $_POST['position_code']
            ]);
        }
        $this->view->redirect('/positions');
    }

    public function delete($id) {
        $position = new Position();
        $result = $position->delete([$id]);

        $this->view->redirect('/positions');
    }
}