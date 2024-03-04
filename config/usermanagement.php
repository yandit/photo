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
            'type'=> 'admin'
        ]
    ],
    'middleware' => [
        'usermanagement.permission'
    ]
];
