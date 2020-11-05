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
    }

    public function run()
    {
        $match = $this->match();

        if ($match !== false) {
            $path = 'app\controllers\\' . ucfirst($this->params['controller']) . 'Controller';

            if (class_exists($path)) {
                $controller = new $path($this->params, $this->extraParams);
            } else {
                View::errorCode(404);
            }
        } else {
            View::errorCode(404);
        }
    }

    private function match()
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