<?php
return [

	// customer
	[
		'name' => 'Customer',
		'code' => 'customer',
		'parent' => '0'
	],
		[
			'name' => 'Create Customer',
			'code' => 'customer.create',
			'parent' => 'customer'
		],
		[
			'name' => 'Customer List',
			'code' => 'customer.index',
			'parent' => 'customer'
		],
		[
			'name' => 'Update Customer',
			'code' => 'customer.edit',
			'parent' => 'customer'
		],
		[
			'name' => 'Delete Customer',
			'code' => 'customer.delete',
			'parent' => 'customer'
		],

];
