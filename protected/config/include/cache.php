<?php
return array(
	'memCache'=>array(
		'enable' => true,
		'frontend' => array(
			'adapter' => 'Data',
			'options' => array('lifetime' => 86400),
		),
		'backend' => array(
			'adapter' => 'memcache',
			'options' => array(
				'prefix'=>'ve-mem-',
				'host'=>'127.0.0.1',
				'port'=>11211,
			)
		)
	),
	'fileCache' => array(
		'enable' => true,
		'frontend' => array(
			'adapter' => 'Data',
			'options' => array('lifetime' => 86400),
		),
		'backend' => array(
			'adapter' => 'File',
			'options' => array(
				'cacheDir' => 'application.runtime.cache.file',
				'prefix'   => "ve-file-"
			)
		)
	)
);
