<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class ImageLib {

    /*
    *   @desc: created a thumb for img
    *   @params: $sourceFile: link file nguon tren server(ca ten file), $filePath: duong dan den file(ko ke`m ten file)
    *            //để gọi 1 img phải trỏ tới thư mục chứa nó trên server(phía server dùng link physic E://xammp/../img_name để lưu img vào), để gọi băng link trang web đầy đủ: http://domain(tương ứng foler public chứa access point index.php)/link->img/img_name
    *               //hay link ko đầy đủ (mặc định có sẵn http://domain/) bắt đầu tính từ folder public 
    */
    public static function thumb($sourceFile, $filePath)
    {           
        $ext = strrchr($sourceFile, '.');
        $fileName = basename($sourceFile, $ext);
        $path = dirname($sourceFile);
        $thumbFile = $path . '/' . $fileName . '_thumb' . $ext;   
        $rs = self::scale($sourceFile, $thumbFile, THUMB_MAX_X, THUMB_MAX_Y);
        if ( ! $rs){
            return false;
        }                        
        $thumbPath = $filePath . '/' . $fileName . '_thumb' . $ext;                 
        return $thumbPath;
    } 
    
	public static function resizeImg($sourceFile, $filePath, $size, $width, $height)
    {           
        $ext = strrchr($sourceFile, '.');
        $fileName = basename($sourceFile, $ext);
        $path = dirname($sourceFile);
        $resizeFile = $path . '/' . $size .'_' . $fileName . $ext;   
        $rs = self::scale($sourceFile, $resizeFile, $width, $height);
        if ( ! $rs){
            return false;
        }                        
        $resizePath = $filePath . '/' . $size .'_' . $fileName . $ext;
        return $resizePath;
    } 
    
    public static function scale($source, $destination, $width, $height)
    {
        $imgInfo = getimagesize($source);
        if ( ! $imgInfo){
            return FALSE;
        }
        $exts = array(1 => 'gif', 2=> 'jpg', 3 => 'png');
        $info = array(
            'width' => $imgInfo[0], 
            'height' => $imgInfo[1], 
            'extension' => $exts[$imgInfo[2]]
        );         
        // don't scale up
        if ($width >= $info['width'] && $height >= $info['height']) {
            return '';
        }                    
        $aspect = $info['height'] / $info['width'];
        if ($aspect < $height / $width) {
            $width = (int)min($width, $info['width']);
            $height = (int)round($width * $aspect);
        } else {
            $height = (int)min($height, $info['height']);
            $width = (int)round($height / $aspect);
        }                   
        $extension = str_replace('jpg', 'jpeg', $info['extension']);
        $openFunc = 'imagecreatefrom' . $extension;
        if ( ! function_exists($openFunc)){
            return FALSE;
        }
        $im = $openFunc($source);     
                
        if ( ! $im){
            return FALSE;
        }
        
        $res = imagecreatetruecolor($width, $height);
        if ($info['extension'] == 'png'){
            $transparency = imagecolorallocatealpha($res, 0, 0, 0, 127);
            imagealphablending($res, FALSE);
            imagefilledrectangle($res, 0, 0, $width, $height, $transparency);
            imagealphablending($res, TRUE);
            imagesavealpha($res, TRUE);
        } elseif ($info['extension'] == 'gif') {
            // If we have a specific transparent color.
            $transparencyIndex = imagecolortransparent($im);
            if ($transparencyIndex >= 0){
                // Get the original image's transparent color's RGB values.
                $transparentColor = imagecolorsforindex($im, $transparencyIndex);
                // Allocate the same color in the new image resource.
                $transparencyIndex = imagecolorallocate($res, $transparentColor['red'], $transparentColor['green'], $transparentColor['blue']);
                // Completely fill the background of the new image with allocated color.
                imagefill($res, 0, 0, $transparencyIndex);
                // Set the background color for new image to transparent.
                imagecolortransparent($res, $transparencyIndex);
                // Find number of colors in the images palette.
                $numberColors = imagecolorstotal($im);
                // Convert from true color to palette to fix transparency issues.
                imagetruecolortopalette($res, TRUE, $numberColors);
            }
        }
        imagecopyresampled($res, $im, 0, 0, 0, 0, $width, $height, $info['width'], $info['height']);
        $result = self::gdClose($res, $destination, $info['extension']);              
        imagedestroy($res);
        imagedestroy($im);
        return $result;                                                              
    }
    
    public static function gdClose($res, $destination, $extension)
    {
        $extension = str_replace('jpg', 'jpeg', $extension);
        $closeFunc = 'image'. $extension;
        if ( ! function_exists($closeFunc)){
            return FALSE;
        }
        if ($extension == 'jpeg'){
            return $closeFunc($res, $destination, 100);
        } else {
            return $closeFunc($res, $destination);
        }
    }
}

/*
 * Author by hungcd
 * End of file upload.php 
 */