<?php
// Include the composer autoload file
include_once "vendor/autoload.php";

// Import the necessary classes
use Carbon\Carbon;
use Intervention\Image\ImageManager;
use Philo\Blade\Blade;

$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';

$blade = new Blade($views, $cache);

$user = new UserAccounts;

$flash = new Flash_Messages();

$capsule = $user->getCapsule();

$flash_msg = '';
$msg = '';
$err = array();
$file_err = false;

if ($flash->hasFlashMessage()) {
	$flash_msg = $flash->show();
}

if ($user->isAdmin()) {

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		if (!file_exists($_FILES['logo-file']['tmp_name'])) {
			array_push($err, 'ID proof not uploaded');
		} else {
			// never assume the upload succeeded
			if ($_FILES['logo-file']['error'] !== UPLOAD_ERR_OK) {
				array_push($err, 'Upload failed with error code ' . $_FILES['logo-file']['error']);
				$file_err = true;
			}

			$info = getimagesize($_FILES['logo-file']['tmp_name']);

			if ($info === FALSE) {
				array_push($err, 'Unable to determine image type of uploaded file');
				$file_err = true;
			}

			if (($info[2] !== IMAGETYPE_GIF) && ($info[2] !== IMAGETYPE_JPEG) && ($info[2] !== IMAGETYPE_PNG)) {
				array_push($err, 'Not a gif/jpeg/png');
				$file_err = true;
			}

			if (!$file_err && empty($err)) {

				$temp_filename = explode(".", $_FILES["logo-file"]["name"]);
				//var_dump($temp);
				$file_ext = end($temp_filename);
				$filename = 'logo-file.' . $file_ext;
				$uploaddir = 'images/client-files/';

				$upload_as = $uploaddir . $filename;

				move_uploaded_file($_FILES['logo-file']['tmp_name'], $upload_as);

				$manager = new ImageManager(array('driver' => 'GD'));

				$manager->make($upload_as)
				        ->resize(300, 300, function ($constraint) {
					        $constraint->aspectRatio();
				        })
				        ->fit(300, 300)
				        ->save($uploaddir . $filename);

				Carbon::now();
			}
		}

	}
	$data = array(
		'type' => 'admin',
		'site_url' => Config::$site_url,
		'page_title' => "Upload Logo",
		'name' => 'Administrator',
		'msg' => $msg,
		'flash' => $flash_msg,
	);
	echo $blade->view()->make('admin.upload-logo', $data);

} else {
	header('Location: ' . Config::$site_url . 'logout.php');
}