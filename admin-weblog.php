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

$img = $images->getScreenLogo();

if ($user->isAdmin()) {

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$date = $_POST['backup-date'];

		$backup_file = 'weblog-backup-' . \Carbon\Carbon::createFromFormat('m-d-Y', $date)->format('Y-m-d') . '.sql.gz';
		if (file_exists('backup-logs/' . $backup_file)) {

			$capsule2 = new Illuminate\Database\Capsule\Manager;
			$capsule2->addConnection([
				'driver' => 'mysql',
				'host' => 'localhost',
				'database' => 'radius_backup',
				'username' => 'root',
				'password' => '',
				'charset' => 'utf8',
				'collation' => 'utf8_unicode_ci',
			]);
			$capsule2->setAsGlobal();

			$capsule2->bootEloquent();

			$capsule2::table('access_log')->truncate();
			$capsule2::table('radacct')->truncate();

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

			$logs = $capsule2::select($capsule2::raw('SELECT DISTINCT b.username, b.callingstationid, a.request_url, DATE(FROM_UNIXTIME(a.time_since_epoch)) FROM access_log a, radacct b where b.framedipaddress = a.client_src_ip_addr and FROM_UNIXTIME(a.time_since_epoch) BETWEEN b.acctstarttime AND b.acctstoptime'));

		} else {
			echo 'no backup_file';
		}

	} else {
		$logs = $capsule::select($capsule::raw('SELECT DISTINCT b.username, b.callingstationid, a.request_url, DATE(FROM_UNIXTIME(a.time_since_epoch)) FROM access_log a, radacct b where b.framedipaddress = a.client_src_ip_addr and FROM_UNIXTIME(a.time_since_epoch) BETWEEN b.acctstarttime AND b.acctstoptime'));
	}

	$data = array(
		'type' => 'admin',
		'site_url' => '',
		'name' => 'Administrator',
		'page_title' => "Operator Details",
		'logo_file' => $img,
		'msg' => $msg,
		'flash' => $flash_msg,
		'weblog' => $logs,
	);

	echo $blade->view()->make('admin.weblog', $data);
} else {
	header('Location: ' . 'logout.php');
}