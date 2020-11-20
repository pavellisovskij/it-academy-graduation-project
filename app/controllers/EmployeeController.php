<?php

namespace app\controllers;

use app\core\Controller;
use app\core\View;
use app\core\Router;
use app\lib\Auth;
use app\lib\Flash;
use app\lib\Paginator;
use app\models\Employee;
use app\models\User;
use app\models\Workplace;
use Rakit\Validation\Validator;

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
        if (Auth::check()) {
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
        else Router::redirect('/signin');
    }

    public function store() {
        if (Auth::check()) {
            $validator = new Validator();

            $validation = $validator->make($_POST, [
                'surname'       => 'required|min:1|max:20',
                'firstname'     => 'required|min:1|max:20',
                'patronymic'    => 'required|min:1|max:20',
                'birthday'      => 'required|date:d.m.Y',
                'hired'         => 'required|date:d.m.Y',
                'medical_exam'  => 'required|date:d.m.Y'
            ]);
            $validation->validate();

            if ($validation->fails()) {
                $errors = $validation->errors();

                foreach ($errors->firstOfAll() as $field => $message) {
                    Flash::set($field, $message);
                }

                Router::redirect('/employee/create');
            }
            else {
                $employee = new Employee();
                $employee = $employee->insert([
                    'surname'       => $_POST['surname'],
                    'firstname'     => $_POST['firstname'],
                    'patronymic'    => $_POST['patronymic'],
                    'birthday'      => $_POST['birthday'],
                    'hired'         => $_POST['hired'],
                    'medical_exam'  => $_POST['medical_exam']
                ]);

                $workplace = new Workplace();
                $workplace = $workplace->update([
                    'employee_id' => $employee
                ], [$_POST['workplace']]);

                Router::redirect("/employee/$employee");
            }
        }
        else Router::redirect('signin');
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
        if (Auth::check()) {
            $employee = new Employee();
            $employee = $employee->find($id)->get();

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
        else Router::redirect('signin');
    }

    public function update($id) {
        if (Auth::check()) {
            if ($_POST['fired'] == '' || !isset($_POST['workplace'])) {
                Flash::set('error', 'Нечего обновлять');
                Router::redirect('/employee/' . $id . '/edit');
            }
            elseif ($_POST['fired'] != '' && isset($_POST['workplace']))
            {
                Flash::set('error', 'Нельзя уволить и одновременно назначить новое рабочее место.');
                Router::redirect('/employee/' . $id . '/edit');
            }
            elseif ($_POST['fired'] == '' && isset($_POST['workplace'])) {
                $workplace = new Workplace();
                $workplace = $workplace->update(['employee_id' => $id], [$_POST['workplace']]);
                Router::redirect('/employee/' . $id);
            }
            elseif ($_POST['fired'] != '' && !isset($_POST['workplace'])) {
                $employee = new Employee();
                $employee = $employee->update(['fired' => $_POST['fired']], [$id]);
                Router::redirect('/employee/' . $id);
            }
        }
        else Router::redirect('/signin');
    }

    public function delete($id) {
        if (Auth::check()) {
            $employee = new Employee();
            $result = $employee->delete([$id]);

            Router::redirect('/employees');
        }
        else Router::redirect('/signin');
    }
}