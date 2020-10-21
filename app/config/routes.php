<?php

return [
    '' => [
        'controller' => 'task',
        'action'     => 'index'
    ],
    'signin' => [
        'controller' => 'user',
        'action'     => 'signin'
    ],
    'login' => [
        'controller' => 'user',
        'action'     => 'login'
    ],
    'departments' => [
        'controller' => 'department',
        'action'     => 'index'
    ],
    'departments/page/{int_page}' => [
        'controller' => 'department',
        'action'     => 'index'
    ],
    'department/create' => [
        'controller' => 'department',
        'action'     => 'create'
    ],
    'department/store' => [
        'controller' => 'department',
        'action'     => 'store'
    ],
    'department/{int_id}' => [
        'controller' => 'department',
        'action'     => 'show'
    ],
    'department/{int_id}/edit' => [
        'controller' => 'department',
        'action'     => 'edit'
    ],
    'department/{int_id}/update' => [
        'controller' => 'department',
        'action'     => 'update'
    ],
    'department/{int_id}/delete' => [
        'controller' => 'department',
        'action'     => 'delete'
    ],
    'employees' => [
        'controller' => 'employee',
        'action'     => 'index'
    ],
    'employees/page/{int_page}' => [
        'controller' => 'employee',
        'action'     => 'index'
    ],
    'employee/create' => [
        'controller' => 'employee',
        'action'     => 'create'
    ],
    'employee/store' => [
        'controller' => 'employee',
        'action'     => 'store'
    ],
    'employee/{int_id}' => [
        'controller' => 'employee',
        'action'     => 'show'
    ],
    'employee/{int_id}/edit' => [
        'controller' => 'employee',
        'action'     => 'edit'
    ],
    'employee/{int_id}/update' => [
        'controller' => 'employee',
        'action'     => 'update'
    ],
    'employee/{int_id}/delete' => [
        'controller' => 'employee',
        'action'     => 'delete'
    ]

//    'task/{id1}/edit/{id2}' => [
//        'controller' => 'task',
//        'action'     => 'edit'
//    ],
];