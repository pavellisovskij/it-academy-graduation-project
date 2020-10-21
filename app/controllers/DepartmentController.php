<?php

namespace app\controllers;

use app\core\Controller;
use app\lib\Paginator;
use app\models\Department;

class DepartmentController extends Controller
{
    public function index(int $page = 1) {
        $department          = new Department();
        $numberOfDepartments = (int) $department->count();
        $departmentPerPage   = 10;
        $pages               = (int) ceil($numberOfDepartments / $departmentPerPage);

        if ($page === 1) $offset = 0;
        else $offset = $page * $departmentPerPage;

        $departments = $department->all()->take(
            $departmentPerPage, $offset
        )->get();

//        foreach ($departments as $department) {
//
//        }

        $paginator = new Paginator($pages, $page, 2, '../departments/page/');

        $this->view->render('Отделы', [
            'departments' => $departments,
            'paginator'   => $paginator
        ]);
    }

    public function create() {
        $this->view->render('Новый отдел');
    }

    public function store() {
        if (!empty($_POST) && isset($_POST['name'])) {
            $department = new Department();
            $department = $department->insert([
                'name'       => $_POST['name'],
                'short_name' => $_POST['short_name']
            ]);
        }
        $this->view->redirect('/departments');
    }

    public function show($id) {
        $department = new Department();
        $department = $department->find($id)->get();


        $this->view->render($department['name'], ['department' => $department]);
    }

    public function edit($id) {
        $department = new Department();
        $department = $department->find($id)->get();

        $this->view->render($department['name'] . '. Редактирование', [
            'department' => $department
        ]);
    }

    public function update($id) {
        $department = new Department();
        $result = $department->update([
            'name'       => $_POST['name'],
            'short_name' => $_POST['short_name']
        ], [$id]);

        $this->view->redirect('/department/' . $id);
    }

    public function delete($id) {
        $department = new Department();
        $result = $department->delete([$id]);

        $this->view->redirect('/departments');
    }
}