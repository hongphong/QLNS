<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class UserManager extends MX_Controller{
	
	public function __construct()
	{
		parent::__construct();
	}
	
    public function validate($username)
    {
        $msg = array();

        //check the length of the username
        if (iconv_strlen($username) < MIN_USERNAME_LENGTH || iconv_strlen($username) > MAX_USERNAME_LENGTH)
                $msg[] = "Tên truy cập phải nằm trong khoảng từ " . MIN_USERNAME_LENGTH . " đến " . MAX_USERNAME_LENGTH . " ký tự. ";

        //check special char
        if (preg_match ("@[^a-z0-9_]+@i", $username)
                ||
                preg_match('/[\x{80}-\x{A0}'.          // Non-printable ISO-8859-1 + NBSP
                                   '\x{AD}'.                 // Soft-hyphen
                                   '\x{2000}-\x{200F}'.      // Various space characters
                                   '\x{2028}-\x{202F}'.      // Bidirectional text overrides
                                   '\x{205F}-\x{206F}'.      // Various text hinting characters
                                   '\x{FEFF}'.               // Byte order mark
                                   '\x{FF01}-\x{FF60}'.      // Full-width latin
                                   '\x{FFF9}-\x{FFFD}'.      // Replacement characters
                                   '\x{0}]/u',               // NULL byte
                                   $username))
                $msg[] = "Tên truy cập không được phép chứa ký tự đặc biệt. ";

        //check Vietnamese characters
        if (preg_match('%(?:'.
                '[\xC2-\xDF][\x80-\xBF]'.        # non-overlong 2-byte
                '|\xE0[\xA0-\xBF][\x80-\xBF]'.               # excluding overlongs
                '|[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}'.      # straight 3-byte
                '|\xED[\x80-\x9F][\x80-\xBF]'.               # excluding surrogates
                '|\xF0[\x90-\xBF][\x80-\xBF]{2}'.    # planes 1-3
                '|[\xF1-\xF3][\x80-\xBF]{3}'.                  # planes 4-15
                '|\xF4[\x80-\x8F][\x80-\xBF]{2}'.    # plane 16
                ')+%xs', $username))
                $msg[] = "Tên truy cập không được chứa ký tự tiếng Việt có dấu. ";

        //check username have ID
        if (strpos($username, '@') !== FALSE && !eregi('@([0-9a-z](-?[0-9a-z])*.)+[a-z]{2}([zmuvtg]|fo|me)?$', $username))
                $msg[] = "Tên truy cập không được chứa ký tự ID";
        //check space in username
        if (strpos($username, ' ') !== FALSE)
                $msg[] = "Tên truy cập không được có khoảng trắng. ";   
		
        //check if the username existed	
		$this->db->where(array('name' => $username));
		$query = $this->db->from("perm_user");
		$existed_user = $query->count_all_results();
        
        if ($existed_user)
			$msg[] = "Tên truy cập bạn chọn đã tồn tại, hãy chọn tên khác. ";
		
        return $msg;
    }
}