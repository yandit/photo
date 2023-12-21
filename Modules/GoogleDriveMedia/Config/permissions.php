<?php
return [
	
	[
		'name' => 'Google Drive Gallery',
		'code' => 'googledrivegallery',
		'parent' => '0'
	],
		[
			'name' => 'Gallery List',
			'code' => 'googledrivegallery.index',
			'parent' => 'googledrivegallery'
		],
	
	[
		'name' => 'Credential',
		'code' => 'googledrivecredential',
		'parent' => '0'
	],
		[
			'name' => 'Credential List',
			'code' => 'googledrivecredential.index',
			'parent' => 'googledrivecredential'
		],
		[
			'name' => 'Update Credential',
			'code' => 'googledrivecredential.edit',
			'parent' => 'googledrivecredential'
		],
	
	// googledrivedisk
	[
		'name' => 'Disk',
		'code' => 'googledrivedisk',
		'parent' => '0'
	],
		[
			'name' => 'Create Disk',
			'code' => 'googledrivedisk.create',
			'parent' => 'googledrivedisk'
		],
		[
			'name' => 'Disk List',
			'code' => 'googledrivedisk.index',
			'parent' => 'googledrivedisk'
		],
		[
			'name' => 'Update Disk',
			'code' => 'googledrivedisk.edit',
			'parent' => 'googledrivedisk'
		],
		[
			'name' => 'Delete Disk',
			'code' => 'googledrivedisk.delete',
			'parent' => 'googledrivedisk'
		],
];
