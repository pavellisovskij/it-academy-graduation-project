<?php

return [
    '' => [
        'controller' => 'workplaces',
        'action'     => 'index'
    ],
    '/' => [
        'controller' => 'workplaces',
        'action'     => 'index'
    ],
    /*user*/
    'signin' => [
        'controller' => 'user',
        'action'     => 'signin'
    ],
    'login' => [
        'controller' => 'user',
        'action'     => 'login'
    ],
    'logout' => [
        'controller' => 'user',
        'action'     => 'logout'
    ],
    /*user*/
    /*position*/
    'positions' => [
        'controller' => 'position',
        'action'     => 'index'
    ],
    'positions/page/{int_page}' => [
        'controller' => 'position',
        'action'     => 'index'
    ],
    'position/create' => [
        'controller' => 'position',
        'action'     => 'create'
    ],
    'position/store' => [
        'controller' => 'position',
        'action'     => 'store'
    ],
    'position/{int_id}/delete' => [
        'controller' => 'position',
        'action'     => 'delete'
    ],
    /*position*/
    /*workplace*/
    'workplaces' => [
        'controller' => 'workplace',
        'action'     => 'index'
    ],
    'workplaces/page/{int_page}' => [
        'controller' => 'workplace',
        'action'     => 'index'
    ],
    'workplace/create' => [
        'controller' => 'workplace',
        'action'     => 'create'
    ],
    'workplace/store' => [
        'controller' => 'workplace',
        'action'     => 'store'
    ],
    'workplace/{int_id}' => [
        'controller' => 'workplace',
        'action'     => 'show'
    ],
    'workplace/{int_id}/edit' => [
        'controller' => 'workplace',
        'action'     => 'edit'
    ],
    'workplace/{int_id}/update' => [
        'controller' => 'workplace',
        'action'     => 'update'
    ],
    'workplace/{int_id}/delete' => [
        'controller' => 'workplace',
        'action'     => 'delete'
    ],
    /*workplace*/
    /*department*/
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
    'departments/all' => [
        'controller' => 'department',
        'action'     => 'all'
    ],
    /*department*/
    /*employee*/
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
    /*employee*/
];