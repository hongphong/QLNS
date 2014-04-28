<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('generate'))
{
    function generate()
	{
		// DECLARE SESSION
		@session_start();
		// LENGTH OF CAPTCHA STRING
		$length=5;
		// FONT SIZE 1 (SMALLEST) - 5 (LARGEST)
		$font = 5;
		// POSSIBLE CHARACTERS IN CAPTCHA STRING
		//$possible = "23456789bcdfghjkmnpqrstvwxyz";
		$possible = "23456789ABCDEFGHJKLMNPQRSTWZV";
		// PATH TO PNG BACKGROUND IMAGE
		$captcha = imagecreatefrompng(CAPTCHA_BASE_IMG_PATH);
		$i = 0;
		$g = 20;
		$hash = "";
	
		// CYCLE THROUGH LETTERS TO MAKE STRING
		while ($i < $length) {
			// GET RANDOM COLOURS, 0-255
			// IN THIS EXAMPLE I HAVE SELECTED DARK COLOURS ONLY SO THE
			// S ARE READABLE ON THE LIGHT BACKGROUND
			$c1 = rand(0, 155);
			$c2 = rand(0, 155);
			$c3 = rand(0, 155);
			$colour = imagecolorallocate($captcha, $c1, $c2, $c3);
			// CHOOSE RANDOM CHARACTER
			$string = substr($possible, mt_rand(0, strlen($possible)-1), 1);
			// BUILD STRING TO SEND TO PROCESSING
			$hash  .= $string;
			// WRITE STRING TO IMAGE
			imagestring($captcha, $font, $g, 10, $string, $colour);
			$i++;
			$g = ($g + 20);
			//  CLEAR LETTERS TO STOP DUPLICATES
			unset($string);
		}
		// SET ENCRYPTED CAPTCHA STRING TO A SESSION STRING
		$_SESSION['captcha'] = md5($hash);
		// OUTPUT CAPTCHA IMAGE
		//imagepng($captcha);
		header('Content-Type: image/jpeg');
		imagejpeg($captcha);
		imagedestroy($captcha);
	}
}
if ( ! function_exists('validate_captcha'))
{
	function validate_captcha($code)
	{
		@session_start();
		if ( ! $code OR ! isset($_SESSION['captcha'])){
			return FALSE;
		}
		$captcha = $_SESSION['captcha'];
		unset($_SESSION['captcha']);
		return md5($code) == $captcha;
	}
}
if ( ! function_exists('destroy'))
{
	function destroy()
	{
		unset($_SESSION['captcha']);
	}  
}
