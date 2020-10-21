<?php

namespace app\lib;

class Validator
{
    protected $errors      = [];
    protected $field_name  = '';
    protected $value       = null;
    protected $params      = [];
    protected $result      = true;

    public function __construct(array $validation_methods)
    {
        foreach ($validation_methods as $validation_method) {
            $method             = $validation_method['method'];
            $this->field_name   = $validation_method['field'];

            if (is_string($validation_method['value'])) $this->value = htmlspecialchars($validation_method['value']);
            else $this->value = $validation_method['value'];

            if (isset($validation_method['params'])) $this->params = $validation_method['params'];

            $result = $this->$method();

            if ($result === true) $this->result = true;
            else {
                $this->result = false;
                if (!isset($this->errors[0][$this->field_name])) $this->errors[0] = [$this->field_name => []];
                $this->errors[0][$this->field_name][] = $result[$this->field_name];
            }
        }
    }

    public function get_errors() {
        if (isset($this->errors[0])) return $this->errors[0];
        else return false;
    }

    public function min_max() {
        $min = $this->min();
        $max = $this->max();

        if ($min === true && $max === true) return true;
        elseif ($min !== true) return $min;
        elseif ($max !== true) return $max;
    }

    public function min() {
        if (is_int($this->value)) {
            if ($this->value >= $this->params['min']) return true;
            else return [
                "$this->field_name" => "Число в поле $this->field_name не может быть меньше " . $this->params['min']
            ];
        }
        elseif (is_string($this->value)) {
            if (mb_strlen($this->value) >= $this->params['min']) return true;
            else return [
                "$this->field_name" => "Поле $this->field_name не может быть короче " . $this->params['min'] . " символов"
            ];
        }
        else return [
            "$this->field_name" => "Ошибка ввода данных в поле $this->field_name"
        ];
    }

    public function max() {
        if (is_int($this->value)) {
            if ($this->value <= $this->params['max']) return true;
            else return [
                "$this->field_name" => "Число в поле $this->field_name не может быть больше " . $this->params['max']
            ];
        }
        elseif (is_string($this->value)) {
            if (mb_strlen($this->value) <= $this->params['max']) return true;
            else return [
                "$this->field_name" => "Поле $this->field_name не может быть длинее " . $this->params['max'] . " символов"
            ];
        }
        else return [
            "$this->field_name" => "Ошибка ввода данных в поле $this->field_name"
        ];
    }

//    public static function regular_expression(string $pattern, string $subject) {
//        return preg_match('#^' . $pattern . '$#', $subject)
//    }
}