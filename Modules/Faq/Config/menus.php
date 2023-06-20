<?php
$prefix = config('usermanagement.admin_prefix');

return [
    [
		'name' => 'FAQ',
        'fa' => 'fa-question',
		'permission' => 'faq.index',         
		'path' => $prefix.'/faq',

	],
];