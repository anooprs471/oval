<?php
return [
	'development' => [
		'type' => 'mysql',
		'host' => 'localhost',
		'port' => '3306',
		'user' => 'root',
		'pass' => '',
		'database' => 'ovalinfo',
	],
	'production' => [
		'type' => 'postgresql',
		'host' => 'localhost',
		'port' => '5432',
		'user' => 'postgres',
		'pass' => 'password',
		'database' => 'test',
	],
];