<?php
$prefix = config('usermanagement.admin_prefix');

return [
    [
		'name' => 'Setting',
        'fa' => 'fa-gear',                
		'path' => $prefix.'/setting',
		'subs' => [
			[
				'name' => 'General',
				'fa' => 'fa-money',        
				'permission' => 'setting.view',
				'path' => $prefix.'/setting/list'
			],	
		]

	],
];