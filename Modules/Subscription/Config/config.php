<?php

return [
    'name' => 'Subscription',



    
    // permission configrautions
    'role_structure' => [
        'superadmin' => [
            'subscriptions' => 'c,r,u,d,p',
            'plans' => 'c,r,u,d,p',
        ],
    ],
    'permission_structure' => [
        'superadmin' => [
            'subscriptions' => 'c,r,u,d,p',
            'plans' => 'c,r,u,d,p',
        ],
    ],


    'permissions_map' => [
        'c'     => 'create',
        'r'     => 'read',
        'u'     => 'update',
        'd'     => 'delete',
        'p'     => 'print',
        'rec'   => 'receive'
    ]
];
