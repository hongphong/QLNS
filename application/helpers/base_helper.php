<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Get the biggest
if (!function_exists('getBiggestNumber')) {
	function getBiggestNumber($arr = array()) {
		if (empty($arr)) return;
		$biggest = $arr[0];
		for ($i=0; $i<count($arr); $i++) {
			$arr[$i] = trim($arr[$i]);
			$arr[$i] = intval($arr[$i]);
			if ($arr[$i] > $biggest) {
				$biggest = $arr[$i];
			}
		}
		return $biggest;
	}
}

if (!function_exists('dump')) {
	function dump($data) {
		print '<pre>';
		print_r($data);
		print '</pre>';
	}
}

if (!function_exists('htmlspecialbo')) {
	function htmlspecialbo($str){
		$arrDenied	= array('<', '>', '\"', '"');
		$arrReplace	= array('&lt;', '&gt;', '&quot;', '&quot;');
		$str = str_replace($arrDenied, $arrReplace, $str);
		return $str;
	}
}

if (!function_exists('alertB')) {
	/*** Show alert box */
	function alertB($message = 'Chả có thông báo gì cả :-S') {
		print '<meta content="text/html" charset="utf-8">';
		print '<body style="background: black;font-family: Arial;font-size: 11px;color: #ACAC9A;">';
		print '<div align="center">';
		print '<table><tr><td align="center">';
		print '<div style="border: 1px dotted gray;padding: 10px 30px;margin-top:20px;color: #ACAC9A;font-family: Arial;font-size: 11px;font-weight: bold;">';
		print $message;
		print '</div>';
		print '</td></tr></table>';
		print '</div>';
		print '</body>';
	}
}

if (!function_exists('validateEmail')) {
	function validateEmail ($email) {
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}
}

if (!function_exists('removeAccent')) {
	function removeAccent($mystring){
		$marTViet=array(
		// Chữ thường
			"à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă","ằ","ắ","ặ","ẳ","ẵ",
			"è","é","ẹ","ẻ","ẽ","ê","ề","ế","ệ","ể","ễ",
			"ì","í","ị","ỉ","ĩ",
			"ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ","ờ","ớ","ợ","ở","ỡ",
			"ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
			"ỳ","ý","ỵ","ỷ","ỹ",
			"đ","Đ","'",
		// Chữ hoa
			"À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă","Ằ","Ắ","Ặ","Ẳ","Ẵ",
			"È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
			"Ì","Í","Ị","Ỉ","Ĩ",
			"Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ","Ờ","Ớ","Ợ","Ở","Ỡ",
			"Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
			"Ỳ","Ý","Ỵ","Ỷ","Ỹ",
			"Đ","Đ","'"
			);
			$marKoDau=array(
			/// Chữ thường
			"a","a","a","a","a","a","a","a","a","a","a","a","a","a","a","a","a",
			"e","e","e","e","e","e","e","e","e","e","e",
			"i","i","i","i","i",
			"o","o","o","o","o","o","o","o","o","o","o","o","o","o","o","o","o",
			"u","u","u","u","u","u","u","u","u","u","u",
			"y","y","y","y","y",
			"d","D","",
         
			//Chữ hoa
			"A","A","A","A","A","A","A","A","A","A","A","A","A","A","A","A","A",
			"E","E","E","E","E","E","E","E","E","E","E",
			"I","I","I","I","I",
			"O","O","O","O","O","O","O","O","O","O","O","O","O","O","O","O","O",
			"U","U","U","U","U","U","U","U","U","U","U",
			"Y","Y","Y","Y","Y",
			"D","D","",
			);
			return str_replace($marTViet, $marKoDau, $mystring);
	}
}

if (!function_exists('delete_file')) {
	function delete_file($filepath) {
		$fullPath = $_SERVER['DOCUMENT_ROOT'] . '/public/uploads/' . $filepath;
		if (file_exists($fullPath)) {
			unlink($fullPath);
			return TRUE;
		}
		return FALSE;
	}
}

if (!function_exists('show_attachment')) {
	function show_attachment($document, $delete=false) {
		if (!empty($document)) {
			print file_attachment($document, $delete);
		}
	}
}

if (!function_exists('getExtention')) {
	function getExtention($filename) {
		$ext = end(explode('.', $filename));
		$ext = substr(strrchr($filename, '.'), 1);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		$ext = preg_replace('/^.*\.([^.]+)$/D', '$1', $filename);
		$exts = split("[/\\.]", $filename);
		$n = count($exts)-1;
		$ext = $exts[$n];
		return $ext;
	}
}

if (!function_exists('file_attachment')) {
	function file_attachment($arFile, $delete = false) {
		$html = '';
		$fullHtml = '';
		if (is_array($arFile)) {
			foreach ($arFile as $doc) {
				$doc['path'] = trim($doc['path']);
				if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/public/uploads/' . $doc['path'])) {
					if (strpos('F'.$doc['path'], '/')) {
						$tmp = explode('/', $doc['path']);
						$fname = $tmp[count($tmp)-1];
						$html .= '<li>';
						$html .= '<a href="'.base_url() . 'public/uploads/' . $doc['path'].'" class="file_name">'. $fname .'</a>';
						if ($delete == true) {
							$html .= '<a id="'. $doc['id'] .'" href="javascript:void(0)" uri="'. $_SERVER['REQUEST_URI'] .'" filepath="'. $doc['path'] .'" onclick="delete_file(this);" class="delete_file"></a>';
						}

						$html .= '<div class="clear"></div>';
						$html .= '</li>';
					}
				}
			}
		}
		if ($html != '') $fullHtml = '<div class="trans-attachment" style="margin-top: 0px;"><ul>' . $html . '</ul></div>';
		return $fullHtml;
	}
}

if (!function_exists('navigation')) {
	function navigation($navi) {
		if (isset($navi)) {
			$i = 0;
			foreach ($navi as $nav) {
				$i++;
				$name = ($i == 1) ? '<b>'.$nav['name'].'</b>' : $nav['name'];
				print '<li><a href="'. $nav['href'] .'">'. $name .'</a></li>';
				if ($i < count($navi)) {
					print '<li>&rsaquo;</li>';
				}
			}
		}
	}
}

if (!function_exists('convert_date_to_time')) {

	// Function convert date(string) to time(int)
	function convert_date_to_time($strDate = "", $strTime = ""){
		//Break string and create array date time
		$array_replace	= array("/", ":");
		$strDate		= str_replace($array_replace, "-", $strDate);
		$strTime		= str_replace($array_replace, "-", $strTime);
		$strDateArray	= explode("-", $strDate);
		$strTimeArray	= explode("-", $strTime);
		$countDateArr	= count($strDateArray);
		$countTimeArr	= count($strTimeArray);

		//Get Current date time
		$today			= getdate();
		$day				= $today["mday"];
		$mon				= $today["mon"];
		$year				= $today["year"];
		$hour				= $today["hours"];
		$min				= $today["minutes"];
		$sec				= $today["seconds"];
		//Get date array
		switch($countDateArr){
			case 2:
				$day		= intval($strDateArray[0]);
				$mon		= intval($strDateArray[1]);
				break;
			case $countDateArr >= 3:
				$day		= intval($strDateArray[0]);
				$mon		= intval($strDateArray[1]);
				$year 	= intval($strDateArray[2]);
				break;
		}
		//Get time array
		switch($countTimeArr){
			case 2:
				$hour		= intval($strTimeArray[0]);
				$min		= intval($strTimeArray[1]);
				break;
			case $countTimeArr >= 3:
				$hour		= intval($strTimeArray[0]);
				$min		= intval($strTimeArray[1]);
				$sec		= intval($strTimeArray[2]);
				break;
		}
		//Return date time integer
		if(@mktime($hour, $min, $sec, $mon, $day, $year) == -1) return $today[0];
		else return mktime($hour, $min, $sec, $mon, $day, $year);
	}
}

if (!function_exists('estimate_time')) {
	function estimate_time($inputSeconds) {
		$delay = 0;
		if ($inputSeconds < 0) {
			$delay = 1;
			$inputSeconds = abs($inputSeconds);
		}

		$secondsInAMinute = 60;
		$secondsInAnHour  = 60 * $secondsInAMinute;
		$secondsInADay    = 24 * $secondsInAnHour;

		// extract days
		$days = floor($inputSeconds / $secondsInADay);

		// extract hours
		$hourSeconds = $inputSeconds % $secondsInADay;
		$hours = floor($hourSeconds / $secondsInAnHour);

		// extract minutes
		$minuteSeconds = $hourSeconds % $secondsInAnHour;
		$minutes = floor($minuteSeconds / $secondsInAMinute);

		// extract the remaining seconds
		$remainingSeconds = $minuteSeconds % $secondsInAMinute;
		$seconds = ceil($remainingSeconds);

		// return the final array
		$obj = array(
	        'd' => (int) $days,
	        'h' => (int) $hours,
	        'm' => (int) $minutes,
	        's' => (int) $seconds,
		);
	  
		if ($delay == 0) {
			$estimeStr = 'Deadline: còn';
			if ($obj['d'] > 0) {
				$estimeStr .= ' <b>' . $obj['d'] . '</b> ngày';
			}
			if ($obj['h'] > 0) {
				$estimeStr .= ' <b>' . $obj['h'] . '</b> giờ';
			}
			if ($obj['m'] > 0) {
				$estimeStr .= ' <b>' . $obj['m'] . '</b> phút';
			}
		} else {
			$estimeStr = 'Đã chậm deadline: ';
			if ($obj['d'] > 0) {
				$estimeStr .= ' <b><font color="red">' . $obj['d'] . '</font></b> ngày';
			}
			if ($obj['h'] > 0) {
				$estimeStr .= ' <b><font color="red">' . $obj['h'] . '</font></b> giờ';
			}
			if ($obj['m'] > 0) {
				$estimeStr .= ' <b><font color="red">' . $obj['m'] . '</font></b> phút';
			}
		}
		return $estimeStr;
	}
}

if (!function_exists('estimate_time_v2')) {
	function estimate_time_v2($inputSeconds) {
		$secondsInAMinute = 60;
		$secondsInAnHour  = 60 * $secondsInAMinute;
		$secondsInADay    = 24 * $secondsInAnHour;

		// extract days
		$days = floor($inputSeconds / $secondsInADay);

		// extract hours
		$hourSeconds = $inputSeconds % $secondsInADay;
		$hours = floor($hourSeconds / $secondsInAnHour);

		// extract minutes
		$minuteSeconds = $hourSeconds % $secondsInAnHour;
		$minutes = floor($minuteSeconds / $secondsInAMinute);

		// extract the remaining seconds
		$remainingSeconds = $minuteSeconds % $secondsInAMinute;
		$seconds = ceil($remainingSeconds);

		// return the final array
		$obj = array(
	        'd' => (int) $days,
	        'h' => (int) $hours,
	        'm' => (int) $minutes,
	        's' => (int) $seconds,
		);
	  
		$estimeStr = '';
		if ($obj['d'] > 0) {
			$estimeStr .= ' <b>' . $obj['d'] . '</b> ngày';
		}
		if ($obj['h'] > 0) {
			$estimeStr .= ' <b>' . $obj['h'] . '</b> giờ';
		}
		if ($obj['m'] > 0) {
			$estimeStr .= ' <b>' . $obj['m'] . '</b> phút';
		}
		if ($obj['s'] > 0) {
			$estimeStr .= ' <b>' . $obj['s'] . '</b> giây';
		}
		if ($inputSeconds <= 0) $estimeStr = '3 giây';
	  
		return $estimeStr;
	}
}

if (!function_exists('super_sort')) {
	function super_sort($myArray, $key, $dimension = 'DESC') {
		for ($i = 0;$i < count($myArray);$i++) {
			for ($j = $i+1;$j < count($myArray);$j++) {
				if (isset($myArray[$i][$key])) {
					if ($dimension == 'DESC') {
						if ($myArray[$i][$key] < $myArray[$j][$key]) {
							$temp = $myArray[$i];
							$myArray[$i] = $myArray[$j];
							$myArray[$j] = $temp;
						}
					} else if ($dimension == 'ASC') {
						if ($myArray[$i][$key] > $myArray[$j][$key]) {
							$temp = $myArray[$i];
							$myArray[$i] = $myArray[$j];
							$myArray[$j] = $temp;
						}
					}
				}
			}
		}
		return $myArray;
	}
}





