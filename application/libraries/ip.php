<?php
class Ip extends MX_Controller {
	
	protected $ip_range = array('192.168.1', '127.0.0');
	
	// Detect network of user logon (on LAN or on Internet)
	public function detect_network($ip) {
		$ip = trim($ip);
		foreach ($this->ip_range as $ipLane) {
			if (strpos('F' . $ip, $ipLane)) {
				return TRUE;
			}
		}
		return FALSE;
	}
	
}



