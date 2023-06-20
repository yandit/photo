<?php
	$prefix = config('usermanagement.admin_prefix');

	return [
		[
			'name' => 'Frames',
			'fa' => 'fa-crop',
			'path' => $prefix.'/frames',
			'order'=> 2,
			'subs' => [
				[
					'name' => 'Stickable',								
					'permission' => 'stickableframe.index',
					'path' => $prefix.'/frames/stickable',
				],
			]
		],
	];