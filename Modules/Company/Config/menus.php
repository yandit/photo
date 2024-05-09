<?php
$prefix = config('usermanagement.admin_prefix');

return [
    [
		'name' => 'Company',
        'fa' => 'fa-building-o',
		'permission' => 'company.index',         
		'order'=> 2,
		'path' => $prefix.'/company',

	],
];