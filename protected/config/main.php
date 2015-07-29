<?php
return array(
	'application'=> include_once 'include/application.php',
	'modules'    => include_once 'include/modules.php',
	'components' => array(
		'crypt'   => md5('api.ve.cn'),
		'router'  => include_once 'include/router.php',
		'database'=> include_once 'include/database.php',
		'volt'    => array(
			'path'  =>'application.runtime.cache.volt',
			'always'=>true,
		),
		'metadata' => array(
			'enable' => true,
			'adapter'=> 'Files',
			'options'=> array(
				'metaDataDir'=> 'application.runtime.cache.schema',
				"lifetime"   => 86400,
				"prefix"     => "meta-"
			)
		),
		'cache' => include_once 'include/cache.php',
		'logger'=> array (
			'enabled'=> true,
			'path'   => 'application.runtime.logs',
			'format' => '[%date%][%type%] %message%',
		),
		'errorHandler'=>'error/index',
	),
);