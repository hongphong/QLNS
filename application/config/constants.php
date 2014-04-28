<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

/*
|--------------------------------------------------------------------------
| Define by hungcd
|--------------------------------------------------------------------------
*/
define ('CAPTCHA_BASE_IMG_PATH',		'./public/captcha/captcha.png');
define ('DATA_DIR', './public/uploads/');
define ("IMG_UPLOAD_MAXFILESIZE", 5*1024*1024);
define ("MAX_WIDTH",     		  400);
define ("MAX_HEIGHT",     		  400);
define ("RESIZE_50_MAX_WIDTH",    50);
define ("RESIZE_50_MAX_HEIGHT",   50);
define ("RESIZE_120_MAX_WIDTH",   120);
define ("RESIZE_120_MAX_HEIGHT",  120);
define ("RESIZE_180_MAX_WIDTH",   180);
define ("RESIZE_180_MAX_HEIGHT",  180);
define ("PER_PAGE_COMMENT", 5);
define ("PER_PAGE_HRM", 30);
define ("MIN_USERNAME_LENGTH",5);
define ("MAX_USERNAME_LENGTH",30);
define ("MIN_PASSWORD_LENGTH",6);
define ("MAX_PASSWORD_LENGTH",50);

/*
|--------------------------------------------------------------------------
| Define by vvdung
|--------------------------------------------------------------------------
*/
define('DATE_FORMAT', 'dd/mm/yyyy');
define('FORMAT_DATE', 'd/m/Y');
define('FORMAT_DATE_TIME', 'd/m/Y H:i');
define('PER_PAGE_KPI', 20);
define('PER_PAGE_PERMISSION', 20);
define('STANDARD_PROJECT', 99);

/*
|--------------------------------------------------------------------------
| Define by NQH
|--------------------------------------------------------------------------
*/
define('PATH_THEME', '/public/template/iso/');
define('NEW_OFFER', 1); //New offer
define('ARISING_OFFER', 2);   //Arising offer
define('MIN_COMPANY_LENGTH', 10);
define('SUPPER_ADMIN', 1);

/* End of file constants.php */
/* Location: ./application/config/constants.php */