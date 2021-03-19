<?php

return [
    'name' => 'المطاعم',
    'icon' => 'icon-restaurant',


    'role_structure' => [

        'superadmin' => [
            'drivers' => 'c,r,u,d',
            'waiters' => 'c,r,u,d',
            'halls' => 'c,r,u,d',
            'tables' => 'c,r,u,d',
            'menus' => 'c,r,u,d',
            'categories' => 'c,r,u,d',
        ],

        'cashier' => [
            'drivers' => 'r,u',
            'waiters' => 'r,u',
            'halls' => 'r,u',
            'tables' => 'r,u',
            'menus' => 'r,u',
        ],

    ],
    'permission_structure' => [
        'superadmin' => [
            'drivers' => 'c,r,u,d',
            'waiters' => 'c,r,u,d',
            'halls' => 'c,r,u,d',
            'tables' => 'c,r,u,d',
            'menus' => 'c,r,u,d',
            'categories' => 'c,r,u,d',
        ],
    ],


    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
        'p' => 'print',
        'rec' => 'receive'
    ]
];
