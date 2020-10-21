<?php

namespace app\controllers;

use app\core\Controller;
use app\models\Test;

class TaskController extends Controller
{
    public function __construct($route)
    {
        parent::__construct($route);
        $this->view->layout = 'newlayout';
    }

    public function index() {
        $this->view->render('new');
    }
}