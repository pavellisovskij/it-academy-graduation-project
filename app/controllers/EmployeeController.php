<?php

namespace app\controllers;

use app\core\Controller;
use app\lib\Paginator;
use app\models\Employee;

class EmployeeController extends Controller
{
    public function index(int $page = 1) {
        $employee          = new Employee();
        $numberOfEmployees = (int) $employee->count();
        $employeePerPage   = 20;
        $pages               = (int) ceil($numberOfEmployees / $employeePerPage);

        if ($page === 1) $offset = 0;
        else $offset = $page * $employeePerPage;

//        $employees = $employee->all()->take(
//            $employeePerPage, $offset
//        )->get();
        $employees = $employee->query("
            SELECT employees.id, employees.firstname, employees.surname, employees.patronymic, departments.short_name
            FROM employees
              INNER JOIN workplaces
              ON employees.id = workplaces.employee_id INNER JOIN departments ON workplaces.department_id = departments.id
        ");
        debug($employees);

//        foreach ($employees as $employee) {
//
//        }

        $paginator = new Paginator($pages, $page, 2, '../employees/page/');

        $this->view->render('Сотрудники', [
            'employees' => $employees,
            'paginator' => $paginator
        ]);
    }

    public function create() {
        $this->view->render('Новый сотрудник');
    }

//    public function store() {
//        if (!empty($_POST) && isset($_POST['name'])) {
//            $department = new Department();
//            $department = $department->insert([
//                'name'       => $_POST['name'],
//                'short_name' => $_POST['short_name']
//            ]);
//        }
//        $this->view->redirect('/departments');
//    }
//
//    public function show($id) {
//        $department = new Department();
//        $department = $department->find($id)->get();
//
//
//        $this->view->render($department['name'], ['department' => $department]);
//    }
//
//    public function edit($id) {
//        $department = new Department();
//        $department = $department->find($id)->get();
//
//        $this->view->render($department['name'] . '. Редактирование', [
//            'department' => $department
//        ]);
//    }
//
//    public function update($id) {
//        $department = new Department();
//        $result = $department->update([
//            'name'       => $_POST['name'],
//            'short_name' => $_POST['short_name']
//        ], [$id]);
//
//        $this->view->redirect('/department/' . $id);
//    }
//
//    public function delete($id) {
//        $department = new Department();
//        $result = $department->delete([$id]);
//
//        $this->view->redirect('/departments');
//    }
}