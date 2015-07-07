<?php
// Include the composer autoload file
include_once "vendor/autoload.php";

use Phelium\Component\MySQLBackup;

$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';

$user = new UserAccounts;

$capsule = $user->getCapsule();

$date = \Carbon\Carbon::now();

$filename = 'weblog-backup-' . $date->format('Y-m-d');

$Dump = new MySQLBackup('localhost', 'root', '', 'ovalinfo');
$Dump->addTable('access_log');
$Dump->setFilename($filename);
$Dump->setDumpStructure(false); // Not the structure
$Dump->setDumpDatas(true); // Not the datas
$Dump->setCompress('gzip');
$Dump->dump();

$backup_file = $filename . '.sql.gz';

if (file_exists($backup_file)) {
	rename($backup_file, 'backup-logs/' . $backup_file);
}

$capsule::table('access_log')->truncate();
