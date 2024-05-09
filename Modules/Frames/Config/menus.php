<?php
	$prefix = config('usermanagement.admin_prefix');

	return [
		[
			'name' => 'Frames',
			'fa' => 'fa-crop',
			'path' => $prefix.'/frames',
			'order'=> 5,
			'subs' => [
				[
					'name' => 'Stickable',								
					'permission' => 'stickableframe.index',
					'path' => $prefix.'/frames/stickable',
				],
			]
		],
	];