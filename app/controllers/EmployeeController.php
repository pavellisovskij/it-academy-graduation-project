<?php

namespace app\controllers;

use app\core\Controller;
use app\core\View;
use app\lib\Paginator;
use app\models\Department;
use app\models\Employee;
use app\models\Workplace;

class EmployeeController extends Controller
{
    public function index($page = 1) {
        $employee          = new Employee();
        $numberOfEmployees = (int) $employee->count();
        $employeePerPage   = 20;
        $pages             = (int) ceil($numberOfEmployees / $employeePerPage);

        if ($page === 1) $offset = 0;
        else $offset = $page * $employeePerPage;

        $employees = $employee->all()->take(
            $employeePerPage, $offset
        )->get();
//        $employees = $employee->query("
//            SELECT employees.id, employees.firstname, employees.surname, employees.patronymic, departments.short_name
//            FROM employees
//              INNER JOIN workplaces
//              ON employees.id = workplaces.employee_id INNER JOIN departments ON workplaces.department_id = departments.id
//        ");

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
//        $department = new Department();
//        $departments = $department->select(['id', 'short_name'])->get();

        $workplaces = new Workplace();
        $workplaces = $workplaces->query("
            SELECT 
                workplaces.id,  
                departments.short_name AS department, 
                positions.name AS pos
            FROM workplaces
            INNER JOIN departments 
                ON workplaces.department_id = departments.id
            INNER JOIN positions
                ON positions.id = workplaces.position_id 
            WHERE workplaces.employee_id IS NULL
        ", Workplace::FETCH_ALL_METHOD);

        $this->view->render('Новый сотрудник', ['workplaces' => $workplaces]);
    }

    public function store() {
        if (!empty($_POST) && isset($_POST['surname'])) {
            $employee = new Employee();
            $employee = $employee->insert([
                'surname'      => $_POST['surname'],
                'firstname'    => $_POST['firstname'],
                'patronymic'   => $_POST['patronymic'],
                'birthday'     => $_POST['birthday'],
                'hired'        => $_POST['hired'],
                'medical_exam' => $_POST['medical_exam']
            ]);

            $workplace = new Workplace();
            $workplace = $workplace->update([
                'employee_id' => $employee
            ], [$_POST['workplace']]);

            if ($workplace > 0) $this->view->redirect("/employee/$employee");
        }
    }

    public function show($id) {
        $employee = new Employee();
        $employee = $employee->find($id)->get();

        if (!empty($employee)) {
            $workplace = new Workplace();
            $workplaces = $workplace->query("
            SELECT 
                workplaces.rate,  
                departments.short_name AS department, 
                positions.name AS pos
            FROM workplaces
            INNER JOIN departments 
                ON workplaces.department_id = departments.id
            INNER JOIN positions
                ON positions.id = workplaces.position_id 
            WHERE workplaces.employee_id = $id
        ", Workplace::FETCH_ALL_METHOD);

            $this->view->render($employee['surname'] . ' ' . $employee['firstname'] . ' ' . $employee['patronymic'], [
                'workplaces' => $workplaces,
                'employee'   => $employee
            ]);
        }
        else View::errorCode(404);
    }
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