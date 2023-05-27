<?php
$prefix = config('usermanagement.admin_prefix');

return [
    [
		'name' => 'FAQ',
        'fa' => 'fa-crop',
		'permission' => 'faq.index',         
		'path' => $prefix.'/faq',

	],
];