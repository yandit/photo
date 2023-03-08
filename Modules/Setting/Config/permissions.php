<?php
return [
	/*	 
	 * admin
	 * role
	 * setting
	 */


	// admin
	// setting
	[
		'name' => 'Setting',
		'code' => 'setting',
		'parent' => '0'
	],
		[
			'name' => 'Create Setting',
			'code' => 'setting.create',
			'parent' => 'setting'
		],
		[
			'name' => 'Setting List',
			'code' => 'setting.view',
			'parent' => 'setting'
		],
		[
			'name' => 'Update Setting',
			'code' => 'setting.edit',
			'parent' => 'setting'
		],
		[
			'name' => 'Delete Setting',
			'code' => 'setting.delete',
			'parent' => 'setting'
		],

];
