<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once 'phpmailer/class.phpmailer.php';

class MyMailer extends PHPMailer {
	function __construct() {
		parent::__construct();
	}
}

