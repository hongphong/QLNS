<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class ValidateQuery extends MX_Controller{
	
	public function __construct()
	{
		parent::__construct();
	}
	
    public function validate($query)
    {
        $msg = array();
		
        //check special char
        if (preg_match ("@[^a-z0-9_]+@i", $query)
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
                                   $query))
                $msg[] = "Từ khóa search không được phép chứa ký tự đặc biệt. ";

        //check Vietnamese characters
        if (preg_match('%(?:'.
                '[\xC2-\xDF][\x80-\xBF]'.        # non-overlong 2-byte
                '|\xE0[\xA0-\xBF][\x80-\xBF]'.               # excluding overlongs
                '|[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}'.      # straight 3-byte
                '|\xED[\x80-\x9F][\x80-\xBF]'.               # excluding surrogates
                '|\xF0[\x90-\xBF][\x80-\xBF]{2}'.    # planes 1-3
                '|[\xF1-\xF3][\x80-\xBF]{3}'.                  # planes 4-15
                '|\xF4[\x80-\x8F][\x80-\xBF]{2}'.    # plane 16
                ')+%xs', $query))
                $msg[] = "Từ khóa search không được chứa ký tự tiếng Việt có dấu. ";

        //check query have ID
        if (strpos($query, '@') !== FALSE && !eregi('@([0-9a-z](-?[0-9a-z])*.)+[a-z]{2}([zmuvtg]|fo|me)?$', $query))
                $msg[] = "Từ khóa search không được chứa ký tự ID";
        //check space in query
        if (strpos($query, ' ') !== FALSE)
                $msg[] = "Từ khóa search không được có khoảng trắng. ";

        return $msg;
    }
}