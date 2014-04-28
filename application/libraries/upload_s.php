<?

/**
 * Class upload image
 */
class upload_s {

    public $msgError = "";
    public $path = "";
    public $filename = "";
    public $extension = "";
    public $type_allow = array();
    public $file_size = "";
    /*
     * upload:: upload()
     * @param $name_control: Ten cua input file control
     * @param $path_upload: Duong dan de upload anh
     * @param $extension_list: Danh sach cac file duoc phep upload
     * @param $maxsize: Dung luong toi da cua file co the upload
     */

    function upload($name_control, $path_upload, $maxsize = 500, $type_allow) {
        //Check isset control upload file
        if (!isset($_FILES[$name_control])) {
            $this->msgError .= "&bull; Không tồn tại control file <b>" . $name_control . "</b><br />";
            return;
        }

        //Check upload loi khac
        if (@!is_uploaded_file($_FILES[$name_control]['tmp_name'])) {
            //$this->msgError	.=	"&bull; Upload không thành công, lỗi is_uploaded_file.<br />";
            return;
        }

        //Check file size
        if (filesize($_FILES[$name_control]['tmp_name']) > $maxsize * 1024) {
            $this->msgError .= "&bull; Dung lượng file upload <b>(" . round(filesize($_FILES[$name_control]['tmp_name']) / 1024, 2) . ")</b> vượt quá giới hạn cho phép (" . $maxsize . ").";
            return;
        }

        //Check extension file
        $ext = $this->getExt($_FILES[$name_control]['name']);
        if (!in_array($ext, $type_allow)) {
            $this->msgError .= "&bull; Định dạng file upload không đúng. Bạn chỉ có thể upload các file có định dạng " . implode(", ", $type_allow);
            return;
        }

        //Doi ten file upload
        $filename_new = chr(rand(97, 122)) . chr(rand(97, 122)) . chr(rand(97, 122));

        $filename_new = $filename_new . time() . "." . $ext;

        //Upload file
        @move_uploaded_file($_FILES[$name_control]['tmp_name'], $path_upload . $filename_new);

        //Kiem tra xem upload vao dung path_upload chua
        if (!is_file($path_upload . $filename_new)) {
            $this->msgError .= "&bull; Đường dẫn để upload file không đúng.<br />";
            return;
        }

        //Kiem tra truong hop khong phai file image nhung co extension o dang image
        if ($this->check_image($path_upload, $filename_new) != 1) {
            $this->msgError .= "&bull; Phần mở rộng của file không tương ứng với định dạng file.<br />";
            return;
        }

        $this->path = $path_upload;
        $this->filename = $filename_new;
        $this->extension = $ext;
    }

    /**
     * Function get extension file upload
     */
    function getExt($filename) {
        $ext = substr($filename, strrpos($filename, ".") + 1);
        return strtolower($ext);
    }

    /**
     * Check extension file upload (Truong hop khong phai file image nhung co duoi cua dang image)
     */
    function check_image($path, $filename) {
        $sExtension = $this->getExt($filename);
        //Check image file type extensiton
        $checkImg = true;
        switch ($sExtension) {
            case "gif":
                $checkImg = @imagecreatefromgif($path . $filename);
                break;
            case "jpg":
            case "jpe":
            case "jpeg":
                $checkImg = @imagecreatefromjpeg($path . $filename);
                break;
            case "png":
                $checkImg = @imagecreatefrompng($path . $filename);
                break;
        }
        if (!$checkImg) {
            $this->delete_file($path, $filename);
            return 0;
        }
        return 1;
    }

    /**
     * Function delete file
     */
    function delete_file($path, $filename) {
        $arrPrefix = array("s_", "m_", "t_", "");
        foreach ($arrPrefix as $value) {
            if (file_exists($path . $value . $filename))
                @unlink($path . $value . $filename);
        }
    }

    /**
     * Function resize_image()
     */
    function resize_image($maxwidth, $maxheight, $quality = 90, $prefix = "s_") {
        //File dung de resize
        $file = $this->path . $this->filename;

        //Lay gia tri width & height cua file dung de resize gan vao 2 bien
        list($img_width, $img_height) = @getimagesize($file);
        if (!$img_width || !$img_height) {
            return false;
        }

        //Lay ti le de resize
        $scale = min($maxwidth / $img_width, $maxheight / $img_height);
        if ($scale > 1)
            $scale = 1;

        //Kich thuoc cua file moi
        $new_width = $img_width * $scale;
        $new_height = $img_height * $scale;

        //Create a new true color image
        $new_img = @imagecreatetruecolor($new_width, $new_height);

        //Kiem tra dinh dang file de lua chon tao file moi
        switch ($this->extension) {
            case "gif":
                $image = imagecreatefromgif($file);
                break;
            case "jpg":
            case "jpe":
            case "jpeg":
                $image = imagecreatefromjpeg($file);
                break;
            case "png":
                $image = imagecreatefrompng($file);
                break;
        }

        //Copy file tu file upload
        imagecopyresampled($new_img, $image, 0, 0, 0, 0, $new_width, $new_height, $img_width, $img_height);

        //Anh tao thanh
        switch ($this->extension) {
            case "gif":
                imagegif($new_img, $this->path . $prefix . $this->filename);
                break;
            case "jpg":
            case "jpe":
            case "jpeg":
                imagejpeg($new_img, $this->path . $prefix . $this->filename, $quality);
                break;
            case "png":
                imagepng($new_img, $this->path . $prefix . $this->filename);
                break;
        }
        //Free up memory (imagedestroy does not delete files):
        @imagedestroy($new_img);
        @imagedestroy($image);
    }

}

?>