<?php
$prefix = config('usermanagement.admin_prefix');

return [
    [
		'name' => 'User Management',
		'fa' => 'fa-users',
		'path' => $prefix.'/usermanagement',
        'order'=> 2,
		'subs' => [
			[
				'name' => 'Role',								
				'permission' => 'role.index',
				'path' => $prefix.'/usermanagement/role',
			],
			[
				'name' => 'Admin',				
				'permission' => 'admin.index',
				'path' => $prefix.'/usermanagement/admin',				
			],
			[
				'name' => 'Role Management',								
				'permission' => 'rolemanagement.create',
				'path' => $prefix.'/usermanagement/rmanagement',
			],	
		]
	],
];