<?php
$prefix = config('usermanagement.admin_prefix');

return [
    [
		'name' => 'Company',
        'fa' => 'fa-user-plus',
		'permission' => 'company.index',         
		'path' => $prefix.'/company',

	],
];