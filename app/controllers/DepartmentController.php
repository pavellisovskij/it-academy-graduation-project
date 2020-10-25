<?php

namespace app\controllers;

use app\core\Controller;
use app\lib\Paginator;
use app\models\Department;
use app\models\User;
use app\models\Workplace;

class DepartmentController extends Controller
{
    public function index(int $page = 1) {
        $department          = new Department();
        $numberOfDepartments = (int) $department->count();
        $departmentPerPage   = 10;
        $pages               = (int) ceil($numberOfDepartments / $departmentPerPage);

        if ($page === 1) $offset = 0;
        else $offset = $page * $departmentPerPage;

        $departments = $department->query("
            SELECT 
	            COUNT(workplaces.id) AS num,  
                departments.id,
                departments.short_name,
                departments.name
            FROM workplaces
            RIGHT OUTER JOIN departments 
                ON workplaces.department_id = departments.id
            GROUP BY workplaces.department_id, departments.name
            ORDER BY departments.name ASC
        ", Department::FETCH_ALL_METHOD);

        $paginator = new Paginator($pages, $page, 2, '../departments/page/');

        $this->view->render('Отделы', [
            'departments' => $departments,
            'paginator'   => $paginator
        ]);
    }

    public function create() {
        if (User::isAdmin()) $this->view->render('Новый отдел');
        else $this->view->redirect('/signin');
    }

    public function store() {
        if (User::isAdmin()) {
            if (!empty($_POST) && isset($_POST['name'])) {
                $department = new Department();
                $department = $department->insert([
                    'name' => $_POST['name'],
                    'short_name' => $_POST['short_name']
                ]);

                if ($department > 0) $this->view->redirect('/departments');
            }
        }
        else $this->view->redirect('/signin');
    }

    public function show(int $id) {
        $department = new Department();
        $department = $department->find($id)->get();

        $workplaces = new Workplace();
        $workplaces = $workplaces->query("
            SELECT 
              workplaces.id,
              workplaces.department_id,
              workplaces.rate, 
              employees.firstname, 
              employees.surname, 
              employees.patronymic,
              positions.name AS pos
            FROM workplaces
            INNER JOIN positions
              ON positions.id = workplaces.position_id
            LEFT OUTER JOIN employees
              ON employees.id = workplaces.employee_id
              WHERE workplaces.department_id = $id
            ORDER BY
               pos ASC,
               employees.surname ASC, 
               employees.firstname ASC,
               employees.patronymic ASC
        ", Workplace::FETCH_ALL_METHOD);

        $this->view->render($department['name'], [
            'department' => $department,
            'worplaces'  => $workplaces
        ]);
    }

    public function edit(int $id)
    {
        if (User::isAdmin()) {
            $department = new Department();
            $department = $department->find($id)->get();

            $this->view->render($department['name'] . '. Редактирование', [
                'department' => $department
            ]);
        }
        else $this->view->redirect('/signin');
    }

    public function update(int $id) {
        if (User::isAdmin()) {
            $department = new Department();
            $result = $department->update([
                'name' => $_POST['name'],
                'short_name' => $_POST['short_name']
            ], [$id]);

            $this->view->redirect('/department/' . $id);
        }
        else $this->view->redirect('/signin');
    }

    public function delete(int $id) {
        if (User::isAdmin()) {
            $department = new Department();
            $result = $department->delete([$id]);

            $this->view->redirect('/departments');
        }
        else $this->view->redirect('/signin');
    }

//    public function all() {
//        $departments = new Department();
//        $departments = $departments->select(['id', 'short_name'])->get();
////        debug(date('d.m.Y'));
//        //debug($departments);
//        header("Content-type: application/json; charset=utf-8");
//
//        echo json_encode($departments);
//    }
}