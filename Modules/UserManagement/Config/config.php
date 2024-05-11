<?php

return [
    'name' => 'UserManagement',
    'admin_prefix' => 'backend',

    // exception for middleware checking
    'permission_exceptions' => [
        'admin.profile',
        'admin.profile_update',
        'googledrive.get'
    ],

    // list role
    'roles' => [
        'superadmin' => [
            'route'=> 'admin.index',
            'role_slug'=> 'superadmin',
            'type'=> 'superadmin'
        ],
        'admin' => [
            'route'=> 'customer.index',
            'role_slug'=> 'admin',
            'type'=> 'admin'
        ],
        'company' => [
            'route'=> 'customer.index',
            'role_slug'=> 'company',
            'type'=> 'company'
        ]
    ],
    'middleware' => [
        'usermanagement.permission'
    ]
];
