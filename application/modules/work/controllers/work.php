<?php
class Work extends MX_Controller {
	
	private $_uid = 0;
	private $_access = array();
	private $_home = 'home';
	private $_template = 'iso/template';
	private $_unit = array(1=>'VNĐ', 2=>'USD');
	private $_rate_important = array(1=>'Bình thường', 2=>'Quan trọng', 3=>'Khẩn cấp');
	private $_rate_important_class = array(1=>'im-low', 2=>'im-hight', 3=>'im-hightest');
	private $_times_delay_color = array(0=>'gray', 1=>'#60994f', 2=>'#f58019', 3=>'red');
	
	function __construct() {
		parent::__construct();
		$this->load->helper('base_helper');
		$this->load->library('iso');
		
		$uid = $this->session->userdata('uid');
		if (intval($uid) > 0) {
			$this->_uid = $uid;
			
			// Group user
			$json = $this->session->userdata('iso_access');
			if ($json) {
				$this->_access = json_decode($json, TRUE);
			} else {
				$this->_access = $this->iso->get_invoke_of_user($uid);
			}
		} else {
			redirect(base_url().$this->_home, 'refresh');
		}
	}
	
	function index() {
		redirect(base_url().'work/today');
	}
	
	function today() {
		$data = array();
		$this->load->model('iso/ProjectModel', 'project');
		
		$fullname = $this->session->userdata('fullname');
		
		// Work filter by function
		$data['workList'] = array();
		$temp = array();
		$_arStepId = array();
		
		if (!empty($this->_access['step'])) $data['listStep'] = $this->_access['step'];
		
		if (!empty($data['listStep'])) {
			foreach ($data['listStep'] as $ls) {
				$temp = array_merge($temp, $ls);
			}
			
			foreach ($temp as $key=>$wl) {
				$_arStepId[] = $wl['id'];
				$temp[$key]['project_name'] = $this->_access['project'][$wl['project_id']]['name'];
				$temp[$key]['rate_important_class'] = $this->_rate_important_class[$wl['rate_important']];
				$temp[$key]['times_delay_color'] = ($wl['times_delay'] < 4) ? $this->_times_delay_color[$wl['times_delay']] : 'red';
			}
		}
		if (!empty($temp)) {
			for ($i=1; $i<=10; $i++) {
				foreach ($temp as $step) {
					if ($i == $step['function']) {
						$data['workList'][$i][] = $step;
					}
				}
			}
		}
		
		// Work new (get from Calendar table)
		$data['workNew'] = $this->iso->get_new_work($this->_uid);
		if (!empty($data['workNew'])) {
			if (!empty($data['workNew'])) {
				foreach ($data['workNew'] as $key=>$wn) {
					if ($wn['project_id'] > 0) {
						$temp = $this->project->get_project('id,name', 'id='.$wn['project_id']);
						$data['workNew'][$key]['project_name'] = $temp[0]['name'];
						$data['workNew'][$key]['times_delay_color'] = ($wn['times_delay'] < 4) ? $this->_times_delay_color[$wn['times_delay']] : 'red';
					}
				}
			}
		}
		
		if (isset($data['workList'][1])) {
			if (!empty($data['workList'][1])) {
				foreach ($data['workList'][1] as $k=>$w1) {
					$timeCom = intval($w1['time_complete']);
					if ($timeCom < 1 || $timeCom < time()) {
						unset($data['workList'][1][$k]);
					}
				}
			}
		}
		
		if (isset($data['workList'][3])) {
			if (!empty($data['workList'][3])) {
				foreach ($data['workList'][3] as $k=>$w1) {
					$timeCom = intval($w1['time_complete']);
					if ($timeCom < 1 || $timeCom < time()) {
						unset($data['workList'][3][$k]);
					}
				}
			}
		}
		
		// Navigation
		$data['navi'] = array(	array('name' => 'Công việc', 'href' => base_url() . 'work'),
										array('name' => $fullname, 'href' => base_url() .'work'));
		
		$data['main_content'] = 'work/work_today';
		
		$this->load->vars($data);
		$this->load->view($this->_template);
	}
	
	function expired() {
		$data = array();
		$this->load->model('iso/ProjectModel', 'project');
		
		$fullname = $this->session->userdata('fullname');
		
		// Work filter by function
		$data['workList'] = array();
		$temp = array();
		$_arStepId = array();
		
		if (!empty($this->_access['step'])) $data['listStep'] = $this->_access['step'];
		
		if (!empty($data['listStep'])) {
			foreach ($data['listStep'] as $ls) {
				$temp = array_merge($temp, $ls);
			}
			
			foreach ($temp as $key=>$wl) {
				$_arStepId[] = $wl['id'];
				$temp[$key]['project_name'] = $this->_access['project'][$wl['project_id']]['name'];
				$temp[$key]['rate_important_class'] = $this->_rate_important_class[$wl['rate_important']];
				$temp[$key]['times_delay_color'] = ($wl['times_delay'] < 4) ? $this->_times_delay_color[$wl['times_delay']] : 'red';
			}
		}
		if (!empty($temp)) {
			for ($i=1; $i<=10; $i++) {
				foreach ($temp as $step) {
					if ($i == $step['function']) {
						$data['workList'][$i][] = $step;
					}
				}
			}
		}
		
		if (isset($data['workList'][1])) {
			if (!empty($data['workList'][1])) {
				foreach ($data['workList'][1] as $k=>$w1) {
					$timeCom = intval($w1['time_complete']);
					if ($timeCom < 1 || $timeCom > time()) {
						unset($data['workList'][1][$k]);
					}
				}
			}
		}
		
		if (isset($data['workList'][3])) {
			if (!empty($data['workList'][3])) {
				foreach ($data['workList'][3] as $k=>$w1) {
					$timeCom = intval($w1['time_complete']);
					if ($timeCom < 1 || $timeCom > time()) {
						unset($data['workList'][3][$k]);
					}
				}
			}
		}
		
		// Navigation
		$data['navi'] = array(	array('name' => 'Công việc', 'href' => base_url() . 'work'),
										array('name' => $fullname, 'href' => base_url() .'work'));
		
		$data['main_content'] = 'work/work_expired';
		
		$this->load->vars($data);
		$this->load->view($this->_template);
	}
	
	function all() {
		$data = array();
		$this->load->model('iso/ProjectModel', 'project');
		
		$fullname = $this->session->userdata('fullname');
		
		// Work filter by function
		$data['workList'] = array();
		$temp = array();
		$_arStepId = array();
		
		if (!empty($this->_access['step'])) $data['listStep'] = $this->_access['step'];
		
		if (!empty($data['listStep'])) {
			foreach ($data['listStep'] as $ls) {
				$temp = array_merge($temp, $ls);
			}
			
			foreach ($temp as $key=>$wl) {
				$_arStepId[] = $wl['id'];
				$temp[$key]['project_name'] = $this->_access['project'][$wl['project_id']]['name'];
				$temp[$key]['rate_important_class'] = $this->_rate_important_class[$wl['rate_important']];
				$temp[$key]['times_delay_color'] = ($wl['times_delay'] < 4) ? $this->_times_delay_color[$wl['times_delay']] : 'red';
			}
		}
		if (!empty($temp)) {
			for ($i=1; $i<=10; $i++) {
				foreach ($temp as $step) {
					if ($i == $step['function']) {
						$data['workList'][$i][] = $step;
					}
				}
			}
		}
		
		// Work new (get from Calendar table)
		$data['workNew'] = $this->iso->get_new_work($this->_uid);
		if (!empty($data['workNew'])) {
			if (!empty($data['workNew'])) {
				foreach ($data['workNew'] as $key=>$wn) {
					if ($wn['project_id'] > 0) {
						$temp = $this->project->get_project('id,name', 'id='.$wn['project_id']);
						$data['workNew'][$key]['project_name'] = $temp[0]['name'];
						$data['workNew'][$key]['times_delay_color'] = ($wn['times_delay'] < 4) ? $this->_times_delay_color[$wn['times_delay']] : 'red';
					}
				}
			}
		}
		
		// Navigation
		$data['navi'] = array(	array('name' => 'Công việc', 'href' => base_url() . 'work'),
										array('name' => $fullname, 'href' => base_url() .'work'));
		
		$data['main_content'] = 'work/work_all';
		
		$this->load->vars($data);
		$this->load->view($this->_template);
	}
}
