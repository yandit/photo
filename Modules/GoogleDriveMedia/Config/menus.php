<?php
	$prefix = config('usermanagement.admin_prefix');

	return [
		[
			'name' => 'Google Drive',
			'fa' => 'fa-google',
			'path' => $prefix.'/google-drive',
			'order'=> 2,
			'subs' => [
				[
					'name' => 'Credential',								
					'permission' => 'googledrivecredential.index',
					'path' => $prefix.'/google-drive/credential',
				],
				[
					'name' => 'Gallery',								
					'permission' => 'googledrivegallery.index',
					'path' => $prefix.'/google-drive/gallery',
				],
			]
		],
	];