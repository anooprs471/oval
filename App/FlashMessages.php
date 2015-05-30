<?php

class FlashMessages extends \Flash_Messages {
	/**
	 * check is there is a message
	 *
	 * @return boolean
	 **/
	public function hasFlashMessage() {
		if (!is_null($_SESSION['flash_message']['message'])) {
			return true;
		} else {
			return false;
		}
	}
}