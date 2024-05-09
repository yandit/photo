<?php
$prefix = config('usermanagement.admin_prefix');

return [
    [
		'name' => 'Customer',
        'fa' => 'fa-user-plus',
		'permission' => 'customer.index',         
		'path' => $prefix.'/customer',
		'order'=> 3,

	],
];