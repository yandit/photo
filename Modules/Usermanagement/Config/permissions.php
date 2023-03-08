<?php
return [
	/*	 
	 * admin
	 * role
	 * setting
	 */


	// admin
	[
		'name' => 'Admin',
		'code' => 'admin',
		'parent' => '0'
	],
		[
			'name' => 'Create Admin',
			'code' => 'admin.create',
			'parent' => 'admin'
		],
		[
			'name' => 'Admin List',
			'code' => 'admin.index',
			'parent' => 'admin'
		],
		[
			'name' => 'Update Admin',
			'code' => 'admin.edit',
			'parent' => 'admin'
		],
		[
			'name' => 'Delete Admin',
			'code' => 'admin.delete',
			'parent' => 'admin'
		],

	// role
	[
		'name' => 'Role',
		'code' => 'role',
		'parent' => '0'
	],
		[
			'name' => 'Create Role',
			'code' => 'role.create',
			'parent' => 'role'
		],
		[
			'name' => 'Role List',
			'code' => 'role.index',
			'parent' => 'role'
		],
		[
			'name' => 'Update Role',
			'code' => 'role.edit',
			'parent' => 'role'
		],
		[
			'name' => 'Delete Role',
			'code' => 'role.delete',
			'parent' => 'role'
		],


	// role management
	[
		'name' => 'Role Management',
		'code' => 'rolemanagement',
		'parent' => '0'
	],
		[
			'name' => 'Manage Role Management',
			'code' => 'rolemanagement.create',
			'parent' => 'rolemanagement'
		],

];
