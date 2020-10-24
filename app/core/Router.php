<?php

namespace app\core;

class Router
{
    protected $routes       = [];
    protected $params       = [];
    protected $extraParams  = [];

    public function __construct()
    {
        $routes = require 'app/config/routes.php';
        $this->routes = $routes;
//        foreach ($routes as $key => $val) {
//            $this->add($key, $val);
//        }
    }

//    public function add($route, $params)
//    {
//        //$route = '#^' . $route . '$#';
//        $this->routes[$route] = $params;
//    }

//    public function match()
//    {
//        $url = trim($_SERVER['REQUEST_URI'], '/');
//        foreach ($this->routes as $route => $params) {
//            if (preg_match($route, $url, $matches)) {
//                $this->params = $params;
//                return true;
//            }
//        }
//        return false;
//    }

    public function run()
    {
        $match = $this->match3();

        if ($match !== false) {
            $path = 'app\controllers\\' . ucfirst($this->params['controller']) . 'Controller';

            if (class_exists($path)) {
                $action = $this->params['action'];

                if (method_exists($path, $action)) {
                    $controller = new $path($this->params);

                    if (count($this->extraParams) === 0) $controller->$action();
                    else $controller->$action(...$this->extraParams);

                } else {
                    View::errorCode(404);
                }
            } else {
                View::errorCode(404);
            }
        } else {
            View::errorCode(404);
        }
    }

    private function match3()
    {
        $url = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        $numberOfUrlParts = count($url);
        $found = false;

        foreach ($this->routes as $route => $params) {
            $route = explode('/', trim($route, '/'));
            $extraParams = [];

            if (count($route) === $numberOfUrlParts) {
                $conformity = false;

                for ($i = 0; $i < $numberOfUrlParts; $i++) {
                    if ($url[$i] === $route[$i]) $conformity = true;
                    elseif ($this->isParam($route[$i]) === true) {
                        $route[$i] = explode('_', trim($route[$i], '{}'));

                        try {
                            if ($route[$i][0] === 'int') $pattern = '#^\d+$#';
                            elseif ($route[$i][0] === 'str') $pattern = '#^[а-яА-ЯёЁa-zA-Z0-9\-_\.@]+$#';
                            else throw new \Exception('Ошибка в наименовании параметров. Параметр должен иметь приставку "int_" или "str_".');
                        } catch (\Exception $e) {
                            View::error_page_with_message($e->getMessage());
                        }

                        if (preg_match($pattern, $url[$i]) === 1) {
                            $extraParams[]  = $url[$i];
                            $conformity     = true;
                        }
                        else {
                            $conformity = false;
                            break;
                        }

                    }
                    else {
                        $conformity = false;
                        break;
                    }
                }
            }
            else continue;

            if ($conformity === true) {
                $this->params       = $params;
                $this->extraParams  = $extraParams;
                $found = true;
                break;
            }
            else {
                $found = false;
                continue;
            }
        }

        if ($found === true) return true;
        else return false;
    }

    private function isParam(string $str) {
        if (
            substr($str, 0, 1) === '{' &&
            substr($str, strlen($str) - 1, 1) === '}'
        ) return true;
        else return false;
    }
}