<?php
$prefix = config('usermanagement.admin_prefix');

return [
    [
		'name' => 'Setting',
        'fa' => 'fa-gear',                
		'path' => $prefix.'/setting',
		'order'=> 1,
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