<?php

namespace app\controllers;

use app\core\Controller;
use app\core\View;
use app\lib\Flash;
use app\lib\Paginator;
use app\models\Employee;
use app\models\User;
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

        $paginator = new Paginator($pages, $page, 2, '../employees/page/');

        $this->view->render('Сотрудники', [
            'employees' => $employees,
            'paginator' => $paginator
        ]);
    }

    public function create()
    {
        if (User::isAdmin()) {
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
        } else $this->view->redirect('/signin');
    }

    public function store() {
        if (User::isAdmin()) {
            if (!empty($_POST) && isset($_POST['surname'])) {
                $employee = new Employee();
                $employee = $employee->insert([
                    'surname' => $_POST['surname'],
                    'firstname' => $_POST['firstname'],
                    'patronymic' => $_POST['patronymic'],
                    'birthday' => $_POST['birthday'],
                    'hired' => $_POST['hired'],
                    'medical_exam' => $_POST['medical_exam']
                ]);

                $workplace = new Workplace();
                $workplace = $workplace->update([
                    'employee_id' => $employee
                ], [$_POST['workplace']]);

                if ($workplace > 0) $this->view->redirect("/employee/$employee");
            }
        }
        else $this->view->redirect('signin');
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

    public function edit($id) {
        if (User::isAdmin()) {
            $employee = new Employee();
            $employee = $employee->find($id)->get();
            $exam = new \DateTime($employee['medical_exam']);
            $employee['medical_exam'] = $exam->format('d.m.Y');

            if (!empty($employee)) {
                $workplaces = new Workplace();

                $workplace = $workplaces->query("
                    SELECT workplaces.id, workplaces.rate, positions.name AS pos, departments.short_name 
                    FROM workplaces 
                    INNER JOIN departments 
                        ON workplaces.department_id = departments.id 
                    INNER JOIN positions 
                        ON positions.id = workplaces.position_id 
                    WHERE workplaces.employee_id = $id
                ", Workplace::FETCH_METHOD);

                $empty_workplaces = $workplaces->query("
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

                $this->view->render($employee['surname'] . ' ' . $employee['firstname'] . ' ' . $employee['patronymic'] . '. Редактирование', [
                    'employee'         => $employee,
                    'workplace'        => $workplace,
                    'empty_workplaces' => $empty_workplaces
                ]);
            }
            else View::errorCode(404);
        }
        else $this->view->redirect('signin');
    }

    public function update($id) {
        if (User::isAdmin()) {
            if ($_POST['fired'] == '' || !isset($_POST['workplace'])) {
                Flash::set('error', 'Нечего обновлять');
                $this->view->redirect('/employee/' . $id . '/edit');
            }
            elseif ($_POST['fired'] != '' && isset($_POST['workplace']))
            {
                Flash::set('error', 'Нельзя уволить и одновременно назначить новое рабочее место.');
                $this->view->redirect('/employee/' . $id . '/edit');
            }
            elseif ($_POST['fired'] == '' && isset($_POST['workplace'])) {
                $workplace = new Workplace();
                $workplace = $workplace->update(['employee_id' => $id], [$_POST['workplace']]);
                $this->view->redirect('/employee/' . $id);
            }
            elseif ($_POST['fired'] != '' && !isset($_POST['workplace'])) {
                $employee = new Employee();
                $employee = $employee->update(['fired' => $_POST['fired']], [$id]);
                $this->view->redirect('/employee/' . $id);
            }
        }
        else $this->view->redirect('/signin');
    }

    public function delete($id) {
        if (User::isAdmin()) {
            $employee = new Employee();
            $result = $employee->delete([$id]);

            if ($result > 0) {
                $this->view->redirect('/employees');
            }
        }
        else $this->view->redirect('/signin');
    }
}