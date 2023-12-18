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
];
