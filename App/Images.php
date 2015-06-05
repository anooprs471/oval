<?php
use Illuminate\Database\Capsule\Manager as Capsule;
use Intervention\Image\ImageManager;

class Images {

	private $capsule;

	private $ImgManager;

	private $err;

	private $uploaddir;

	public function __construct() {
		$this->capsule = new Capsule;
		$this->capsule->addConnection([
			'driver' => 'mysql',
			'host' => 'localhost',
			'database' => 'ovalinfo',
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
			'collation' => 'utf8_unicode_ci',
		]);

		$this->capsule->bootEloquent();

		$this->ImgManager = new ImageManager(array('driver' => 'GD'));
		//$this->ImgManager = new ImageManager(array('driver' => 'Imagick'));

		$this->uploaddir = 'images/client-files/';

	}

	function getScreenLogo() {
		$logo = $this->capsule->table('images')
		             ->where('type', '=', 'logo-screen')
		             ->first();

		return $logo['image_name'];
	}

	function getPrintLogo() {
		$logo = $this->capsule->table('images')
		             ->where('type', '=', 'logo-print')
		             ->first();

		return $logo['image_name'];
	}

	function getScrollAds() {
		$ads = $this->capsule->table('images')
		            ->where('type', '=', 'scroll-ad')
		            ->get();

		return $ads;
	}

	function getLoginRightAd() {
		$logo = $this->capsule->table('images')
		             ->where('type', '=', 'ad-login-right')
		             ->first();

		return $logo['image_name'];
	}

	function getLoginBottomAd() {
		$logo = $this->capsule->table('images')
		             ->where('type', '=', 'ad-login-bottom')
		             ->first();

		return $logo['image_name'];
	}

	function addLogo($file) {

		$logo_print = $this->uploadTheFile($file, 'logo-file-print');

		$name_splt = explode(".", $logo_print);

		$file_ext = end($name_splt);

		$logo_screen = 'logo-screen' . '.' . $file_ext;

		$this->ImgManager->make($this->uploaddir . $logo_print)
			->resize(300, 300, function ($constraint) {
				$constraint->aspectRatio();
			})
			->save($this->uploaddir . $logo_print)
			->resize(180, 50, function ($constraint) {
				$constraint->aspectRatio();
			})
			->save($this->uploaddir . $logo_screen);

		$this->capsule->table('images')
		     ->where('type', '=', 'logo-print')
		     ->delete();
		$this->capsule->table('images')
		     ->where('type', '=', 'logo-screen')
		     ->delete();
		// if ($db_logos != null) {
		// 	$db_logos->delete();
		// }

		$logo_files = array(
			array('image_name' => $logo_print, 'type' => 'logo-print'),
			array('image_name' => $logo_screen, 'type' => 'logo-screen'),
		);

		$this->capsule->table('images')
		     ->insert($logo_files);

	}

	function addLoginScreenRightAd($file) {

		$ad = $this->uploadTheFile($file, 'ad-login-right');
		$this->ImgManager->make($this->uploaddir . $ad)
			->resize(300, 300, function ($constraint) {
				$constraint->aspectRatio();
			})
			->fit(300, 300)
			->save($this->uploaddir . $ad);

		$this->capsule->table('images')
		     ->where('type', '=', 'ad-login-right')
		     ->delete();
		$this->capsule->table('images')
		     ->insert(array('image_name' => $ad, 'type' => 'ad-login-right'));
	}

	function addLoginScreenBottomAd($file) {
		$ad = $this->uploadTheFile($file, 'ad-login-bottom');
		$this->ImgManager->make($this->uploaddir . $ad)
			->resize(800, 150, function ($constraint) {
				$constraint->aspectRatio();
			})
			->fit(800, 150)
			->save($this->uploaddir . $ad);

		$this->capsule->table('images')
		     ->where('type', '=', 'ad-login-bottom')
		     ->delete();
		$this->capsule->table('images')
		     ->insert(array('image_name' => $ad, 'type' => 'ad-login-bottom'));
	}

	function addScrollAds($file) {
		$insert = array();
		//Loop through each file
		for ($i = 0; $i < count($_FILES[$file]['name']); $i++) {
			//Get the temp file path
			$tmpFilePath = $_FILES[$file]['tmp_name'][$i];

			//Make sure we have a filepath
			if ($tmpFilePath != "") {
				//Setup our new file path
				$newFilePath = $this->uploaddir . $_FILES[$file]['name'][$i];

				//Upload the file into the temp dir
				if (move_uploaded_file($tmpFilePath, $newFilePath)) {

					$this->ImgManager->make($newFilePath)
					     ->resize(250, 250, function ($constraint) {
						     $constraint->aspectRatio();
					     })
					     ->fit(250, 250)
					     ->save($newFilePath);

					//Handle other code here
					array_push($insert, array('image_name' => $_FILES[$file]['name'][$i], 'type' => 'scroll-ad'));

				}
			}

		}
		$this->capsule->table('images')
		     ->insert($insert);
	}

	public function removeImage($image_id) {

		$image = $this->capsule->table('images')->find($image_id);

		if ($image != null) {
			$del_file = $this->uploaddir . $image['image_name'];

			if (file_exists($del_file)) {
				unlink($del_file);
			}

			$this->capsule->table('images')
			     ->where('id', '=', $image_id)
			     ->delete();
		}

	}

	private function isImage($file) {

		$file_err = false;

		if (!file_exists($_FILES[$file]['tmp_name'])) {
			array_push($err, 'ID proof not uploaded');
			$file_err = true;
		} else {
			if ($_FILES[$file]['error'] !== UPLOAD_ERR_OK) {
				array_push($err, 'Upload failed with error code ' . $_FILES[$file]['error']);
				$file_err = true;
			}

			$info = getimagesize($_FILES[$file]['tmp_name']);

			if ($info === FALSE) {
				array_push($err, 'Unable to determine image type of uploaded file');
				$file_err = true;
			}

			if (($info[2] !== IMAGETYPE_GIF) && ($info[2] !== IMAGETYPE_JPEG) && ($info[2] !== IMAGETYPE_PNG)) {
				array_push($err, 'Not a gif/jpeg/png');
				$file_err = true;
			}

		}

		return !$file_err;
	}

	private function uploadTheFile($file, $filename = null) {
		if ($this->isImage($file)) {

			if ($filename != null) {
				$temp_filename = explode(".", $_FILES[$file]['name']);
				$file_ext = end($temp_filename);
				$upload_name = $filename . '.' . $file_ext;
				move_uploaded_file($_FILES[$file]['tmp_name'], $this->uploaddir . $upload_name);
				return $upload_name;
			} else {
				move_uploaded_file($_FILES[$file]['tmp_name'], $this->uploaddir . $_FILES[$file]['name']);
				return $_FILES[$file]['name'];
			}

		}
	}

}