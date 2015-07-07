<?php
// Include the composer autoload file
include_once "vendor/autoload.php";

use BackupManager\Compressors;
use BackupManager\Config\Config;
use BackupManager\Databases;
use BackupManager\Filesystems;
use BackupManager\Manager;
use Philo\Blade\Blade;

$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';

$blade = new Blade($views, $cache);

$user = new UserAccounts;

$images = new Images;

$capsule = $user->getCapsule();

$patient_details = array();

$msg = '';

$flash_msg = '';

$data_err = false;

if ($user->isAdmin()) {

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$date = $_POST['backup-date'];

		$backup_file = 'weblog-backup-' . \Carbon\Carbon::createFromFormat('m-d-Y', $date)->format('Y-m-d') . '.sql.gz';
		if (file_exists('backup-logs/' . $backup_file)) {

			// Back-up manager bootstrap

			$filesystems = new Filesystems\FilesystemProvider(Config::fromPhpFile('config/storage.php'));
			$filesystems->add(new Filesystems\LocalFilesystem);

			$databases = new Databases\DatabaseProvider(Config::fromPhpFile('config/database.php'));
			$databases->add(new Databases\MysqlDatabase);

			$compressors = new Compressors\CompressorProvider;
			$compressors->add(new Compressors\GzipCompressor);

			// build manager
			$manager = new Manager($filesystems, $databases, $compressors);
			$manager->makeRestore()->run('local', $backup_file, 'development', 'gzip');

		} else {
			echo 'no backup_file';
		}

	}

	$logs = $capsule::select($capsule::raw('SELECT DISTINCT b.username, b.callingstationid, a.request_url, DATE(FROM_UNIXTIME(a.time_since_epoch)) FROM access_log a, radacct b where b.framedipaddress = a.client_src_ip_addr and FROM_UNIXTIME(a.time_since_epoch) BETWEEN b.acctstarttime AND b.acctstoptime'));

	$data = array(
		'type' => 'admin',
		'site_url' => '',
		'name' => 'Administrator',
		'page_title' => "Operator Details",
		'logo_file' => $images->getScreenLogo(),
		'msg' => $msg,
		'flash' => $flash_msg,
		'weblog' => $logs,
	);

	echo $blade->view()->make('admin.weblog', $data);
} else {
	header('Location: ' . Config::$site_url . 'logout.php');
}