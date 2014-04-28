<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UploadManager extends MX_Controller {

	function __construct() {

		$this->load->library('ImageLib');
		$this->load->library('Resize');
		$this->load->helper('url');
		$this->load->helper('base_helper');
	}

	public static function uploadImage($name, $limit = 4, $resize = FALSE, $thumb_50 = FALSE, $thumb_120 = FALSE, $thumb_180 = FALSE, $maxSize=false)
	{
		if (isset($_FILES) AND count($_FILES) > 0 AND count($_FILES) <= $limit) {
			if($_FILES[$name]['name'] != '' AND is_uploaded_file($_FILES[$name]['tmp_name'])){
				if ($_FILES[$name]['size'] > IMG_UPLOAD_MAXFILESIZE){
					return false;
				}

				$data = array(
                    'origin'        => '',
					'resize_origin' => '',
                    'thumb_50'      => '',
					'thumb_120'     => '',
					'thumb_180'     => '',
				);
				$basePath       = DATA_DIR;

				$t = getdate(time());
				$imagePath = $t['year'] . '/' . $t['mon'] . '/' . $t['mday'] . '/' . $t['hours'];
				$path = $basePath . $imagePath;

				if ( ! is_dir($path)){
					mkdir($path, 0777, true);
				}
				//var_dump($path);
				$fileName = $_FILES[$name]['name'];
				$imgName = rand() . '_' . strtolower($fileName);
				$img_name = self::normalizeFilename($imgName);

				//check extension
				$arr = explode('.', $imgName);
				if (empty($arr)){
					return '';
				}
				$ext = $arr[count($arr)-1];
				if ($ext != 'jpg' && $ext != 'jpeg' && $ext != 'gif' && $ext != 'png' && 'gif'){
					if($ext == 'xlsx' || $ext == 'xls' || $ext == 'pdf' || $ext == 'doc' || $ext == 'docx' || $ext == 'ppt' || $ext == 'pptx'){
						/* hash img file to unique*/
						$extension = self::getExtension($imgName);
						$imgName = md5($imgName).'.'.$extension;
							
						$sourceFile = $path . '/' .$imgName;
						list( $width, $height ) = @getimagesize( $_FILES[$name]['tmp_name'] );
						move_uploaded_file($_FILES[$name]['tmp_name'], $sourceFile);

						$data['origin'] 	   = $imagePath . '/' . $imgName;
						$data['resize_origin'] = $imagePath . '/' . $imgName;
						$data['thumb_50'] 	   = $imagePath . '/' . $imgName;
						$data['thumb_120'] 	   = $imagePath . '/' . $imgName;
						$data['thumb_180'] 	   = $imagePath . '/' . $imgName;
						return $data;
					} else {
						return '';
					}
				}
				/* hash img file to unique*/
				$extension = self::getExtension($imgName);
				$imgName = md5($imgName).'.'.$extension;
					
				$sourceFile = $path . '/' .$imgName;
				list( $width, $height ) = @getimagesize( $_FILES[$name]['tmp_name'] );
				move_uploaded_file($_FILES[$name]['tmp_name'], $sourceFile);

				/* create thumb and keep the full image maxsize 50 */
				if($thumb_50){
					if($width > RESIZE_50_MAX_WIDTH || $height > RESIZE_50_MAX_HEIGHT ){
						$data['thumb_50'] = ImageLib::resizeImg($sourceFile, $imagePath, 50, RESIZE_50_MAX_WIDTH, RESIZE_50_MAX_HEIGHT);
					}else{
						$data['thumb_50'] = $imagePath . '/' . $imgName;
					}
				}
				/* create thumb and keep the full image maxsize 50 */
				if($thumb_120){
					if($width > RESIZE_120_MAX_WIDTH || $height > RESIZE_120_MAX_HEIGHT ){
						$data['thumb_120'] = ImageLib::resizeImg($sourceFile, $imagePath, 120, RESIZE_120_MAX_WIDTH, RESIZE_120_MAX_HEIGHT);
					}else{
						$data['thumb_120'] = $imagePath . '/' . $imgName;
					}
				}
				/* create thumb and keep the full image maxsize 50 */
				if($thumb_180){
					if($width > RESIZE_180_MAX_WIDTH || $height > RESIZE_180_MAX_HEIGHT ){
						$data['thumb_180'] = ImageLib::resizeImg($sourceFile, $imagePath, 180, RESIZE_180_MAX_WIDTH, RESIZE_180_MAX_HEIGHT);
					}else{
						$data['thumb_180'] = $imagePath . '/' . $imgName;
					}
				}
				/* resize if large img before cropping*/
				if($maxSize){
					if($width > MAX_WIDTH || $height > MAX_HEIGHT ){
						$data['origin'] = ImageLib::resizeImg($sourceFile, $imagePath, 'resize', MAX_WIDTH, MAX_HEIGHT);
						@unlink($sourceFile);#unlink after resize source
					}else{
						$data['origin'] = $imagePath . '/' . $imgName;
					}
				}else{
					if($resize){
						/* crop image for beautiful image */
						$patch  = base_url() . 'public/uploads/' . $imagePath . '/' . $imgName;
						$resize = new Resize($patch);
						$resize->resizeImage(150, 100, 'crop');
						$resize->saveImage( 'public/uploads/' . $imagePath  . '/resize_'.$imgName, 100);
						$data['resize_origin'] = $imagePath . '/' . 'resize_'.$imgName;
					}

					/* image true */
					$data['origin'] = $imagePath . '/' . $imgName;
				}
				return $data;
			}
		}
		return FALSE;
	}

	public static function uploadImages($name, $what, $limit = 10) {
	
	
	
		//if (isset($_FILES) && count($_FILES) > 0 && count($_FILES) <= $limit) {
			if($_FILES[$name]['name'][$what] != '' && is_uploaded_file($_FILES[$name]['tmp_name'][$what])) {
				
				if ($_FILES[$name]['size'][$what] > IMG_UPLOAD_MAXFILESIZE) {
					return false;
				}
				
				
				$data = array('origin' => '');
				$basePath = DATA_DIR;

				$t = getdate(time());
				$imagePath = $t['year'] . '/' . $t['mon'] . '/' . $t['mday'] . '/' . $t['hours'];
				$path = $basePath . $imagePath;

				if ( ! is_dir($path)){
					mkdir($path, 0777, true);
				}

				$fileName = $_FILES[$name]['name'][$what];
				$imgName = $fileName;
				$img_name = self::normalizeFilename($imgName);

				// Check extension
				$arr = explode('.', $imgName);
				if (empty($arr)) {
					return '';
				}
				$ext = $arr[count($arr)-1];
				$extension = self::getExtension($imgName);
				$temp = str_replace('.'.$extension, '', $imgName);
				$temp = str_replace(' ', '_', removeAccent($temp));
				$imgName = $temp . '_' . rand(1000,9999) . '.' . $extension;

				$sourceFile = $path . '/' .$imgName;
				list( $width, $height ) = @getimagesize( $_FILES[$name]['tmp_name'][$what] );
				$f = move_uploaded_file($_FILES[$name]['tmp_name'][$what], $sourceFile);
				

				/** Return name and path of file upload */
				$data['origin'] = $imagePath . '/' . $imgName;
				return $data;
			}
		//}
		return FALSE;
	}

	public static function normalizeFilename($fileName) {
		$specialChars = array ("#", "$", "%", "^", "&", "*", "!", "~", "Ã¯Â¿Â½", "\"", "Ã¯Â¿Â½", "'", "=", "?", "/", "[", "]", "(", ")", "|", "<", ">", ";", "\\", ",");
		$fileName = str_replace($specialChars, "", $fileName);  // remove special characters
		return $fileName;
	}

	/*
	 * @desc: get extension of file *.ext
	 */
	function getExtension($str) {
		$i = strrpos($str,".");
		if (!$i) { return ""; }
		$l = strlen($str) - $i;
		$ext = substr($str,$i+1,$l);
		return $ext;
	}
}









