<?php

namespace app\controllers;

use app\core\Controller;
use app\core\View;
use app\core\Router;
use app\lib\Auth;
use app\lib\Flash;
use app\lib\Paginator;
use app\models\Department;
use app\models\Position;
use app\models\User;
use app\models\Workplace;
use Rakit\Validation\Validator;

class WorkplaceController extends Controller
{
    public function index($page = 1) {
        $workplace          = new Workplace();
        $numberOfWorkplaces = (int) $workplace->count();
        $workplacesPerPage  = 20;
        $pages              = (int) ceil($numberOfWorkplaces / $workplacesPerPage);

        if ($page === 1) $offset = 0;
        else $offset = $page * $workplacesPerPage;

        $workplaces = $workplace->query("
            SELECT 
              workplaces.id,
              workplaces.rate, 
              employees.firstname, 
              employees.surname, 
              employees.patronymic, 
              departments.short_name AS department, 
              positions.name AS pos
            FROM workplaces
            INNER JOIN departments 
              ON workplaces.department_id = departments.id
            INNER JOIN positions
              ON positions.id = workplaces.position_id
            LEFT OUTER JOIN employees
              ON employees.id = workplaces.employee_id 
            ORDER BY
               department ASC,
               pos ASC,
               employees.surname ASC, 
               employees.firstname ASC,
               employees.patronymic ASC
            LIMIT $workplacesPerPage OFFSET $offset
        ", Workplace::FETCH_ALL_METHOD);

        $paginator = new Paginator($pages, $page, 2, '../workplaces/page/');

        $this->view->render('Штатное расписание', [
            'workplaces' => $workplaces,
            'paginator'  => $paginator
        ]);
    }

    public function create() {
        if (Auth::check()) {
            $department = new Department();
            $departments = $department->all()->get();

            $position = new Position();
            $positions = $position->all()->get();

            $this->view->render('Новое рабочее место', [
                'departments' => $departments,
                'positions' => $positions
            ]);
        }
        else Router::redirect('/signin');
    }

    public function store() {
        if (Auth::check()) {
            $validator = new Validator();

            $validation = $validator->make($_POST, [
                'rate' => 'required|max:1|min:0.1'
            ]);
            $validation->validate();

            if ($validation->fails()) {
                $errors = $validation->errors();

                foreach ($errors->firstOfAll() as $field => $message) {
                    Flash::set($field, $message);
                }

                Router::redirect('/workplace/create');
            }
            else {
                $workplace = new Workplace();
                $workplaces = $workplace->insert([
                    'rate'          => $_POST['rate'],
                    'department_id' => $_POST['department'],
                    'position_id'   => $_POST['position']
                ]);

                Router::redirect('/workplaces');
            }
        }
        else Router::redirect('/signin');
    }

    public function show($id) {
        $workplace = new Workplace();
        $workplace = $workplace->query("
            SELECT 
              workplaces.id,
              workplaces.rate, 
              employees.firstname, 
              employees.surname, 
              employees.patronymic, 
              departments.short_name AS department, 
              positions.name AS pos
            FROM workplaces
            INNER JOIN departments 
              ON workplaces.department_id = departments.id
            INNER JOIN positions
              ON positions.id = workplaces.position_id
            LEFT OUTER JOIN employees
              ON employees.id = workplaces.employee_id 
            WHERE workplaces.id = $id
        ", Workplace::FETCH_METHOD);

        if ($workplace == false) View::errorCode(404);
        else $this->view->render(
            $workplace['department'] . ': ' . $workplace['pos'],
            ['workplace' => $workplace]
        );
    }

    public function edit($id) {
        if (Auth::check()) {
            $workplace = new Workplace();
            $workplace = $workplace->query("
            SELECT 
              workplaces.*, 
              departments.short_name AS department, 
              positions.name AS pos
            FROM workplaces
            INNER JOIN departments 
              ON workplaces.department_id = departments.id
            INNER JOIN positions
              ON positions.id = workplaces.position_id
            WHERE workplaces.id = $id
        ", Workplace::FETCH_METHOD);

            $department  = new Department();
            $departments = $department->all()->get();

            $position  = new Position();
            $positions = $position->all()->get();

            $this->view->render('Редактирование рабочего места ' . $workplace['department'] . ': ' . $workplace['pos'], [
                'departments' => $departments,
                'positions'   => $positions,
                'workplace'   => $workplace
            ]);
        }
        else Router::redirect('/signin');
    }

    public function update($id) {
        if (Auth::check()) {
            $validator = new Validator();

            $validation = $validator->make($_POST, [
                'rate' => 'required|max:1|min:0.1'
            ]);
            $validation->validate();

            if ($validation->fails()) {
                $errors = $validation->errors();

                foreach ($errors->firstOfAll() as $field => $message) {
                    Flash::set($field, $message);
                }

                Router::redirect("/workplace/$id/edit");
            }
            else {
                $workplace  = new Workplace();
                $workplace = $workplace->update([
                    'rate'          => $_POST['rate'],
                    'department_id' => $_POST['department'],
                    'position_id'   => $_POST['position']
                ], [$id]);

                Router::redirect("/workplace/$id");
            }
        }
        else Router::redirect('/signin');
    }

    public function delete($id) {
        if (Auth::check()) {
            $workplace = new Workplace();
            $workplaceById = $workplace->find($id)->get();

            if ($workplaceById['employee_id'] === null) {
                $result = $workplace->delete([$id]);

                if ($result > 0) Router::redirect('/workplaces');
                else View::errorCode(400);
            }
            else {
                Router::redirect("/workplace/$id");
            }
        }
        else Router::redirect('/signin');
    }
}