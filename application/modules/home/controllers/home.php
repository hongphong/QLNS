<?php
class Home extends MX_Controller{
	private $_uid = 0;
	private $_template = "iso/template";
	private $_template_login = "login/template";

	function __construct(){
		parent::__construct();
		$this->load->helper('base_helper');
	}

	public function index() {
		$data = array();
		$uid = $this->session->userdata('uid');
		if ($uid > 0) {
			$this->_uid = $uid;
			redirect('home/sucessfully','refresh');
		}
		$this->load->vars($data);
		$this->load->view($this->_template_login);
	}

	public function login() {
		$reUrl = $this->input->get('ref');
		if ($this->input->post('submit')){
			$user_name = $this->input->post('username');
			$password  = $this->input->post('password');

			// Load model
			$this->load->model('System_user', 'user');
			if($this->user->checkUser($user_name, $password)) {
				$uid = $this->session->userdata('uid');
				if ($uid > 0) {
					$this->_uid = $uid;

					// Insert into log table
					$this->load->model('hrm/ReportLogModel', 'reportlog');
					$log['uid'] = $uid;
					$log['time'] = time();
					$log['day'] = date('d');
					$log['month'] = date('m');
					$log['year'] = date('Y');
					$log['action'] = 'login';
					$log['ip'] = $_SERVER['REMOTE_ADDR'];

					// Detect ip
					$this->load->library('ip', 'ip');
					$detect = $this->ip->detect_network($_SERVER['REMOTE_ADDR']);
					if ($detect) {
						$log['from'] = 'lan';
					} else {
						$log['from'] = 'internet';
					}
					$this->reportlog->put($log);

					// Check popup
					$current = time();
					$sql = "SELECT * FROM popup WHERE uid = $uid AND day = ".date('d');
					$db = $this->db->query($sql);
					$popupRec = $db->row_array();
					$showPopup = 0;

					$data['uid'] = $uid;
					$data['lastime'] = time();
					$data['day'] = date('d');
					$data['time_appear'] = 1;

					if ($popupRec) {
						if ((time() - $popupRec['lastime']) > 2500000) { // 1 tháng sau
							$this->db->insert('popup', $data);
							$showPopup = 1;
						}
					} else {
						$this->db->insert('popup', $data);
						$showPopup = 1;
					}
						
					// Redirect
					redirect('/hrm');
				}
			} else {
				$this->session->set_flashdata('error', "Sai User hoặc Pass. Thử lại nhé!");
				redirect(base_url());
			}
		} else {
			$this->session->set_flashdata('error', "Bạn chưa đăng nhập");
			redirect(base_url());
		}
	}

	public function spop($uid) {
		if ($uid > 0) {
			$this->load->model('home/TaskModel', 'task');
			$data['allTask'] = $this->task->get_task_by_user($uid);

			// Work new update (get from calendar table)
			$this->load->library('iso');
			$data['allTask']['newUpdate'] = $this->iso->get_new_work($uid);

			// Work lead
			if (!empty($data['allTask'][1])) {
				foreach ($data['allTask'][1] as $item) {
					if ($item['iso_type'] == 'step') {
						$data['stepExecutive'][] = $item;
					}
					if ($item['iso_type'] == 'transaction') {
						$data['transactionExecutive'][] = $item;
					}
				}
			}
			if ($this->input->is_ajax_request()) {

			} else {
				return $data;
			}
		}
	}

	public function sucessfully() {
		$uid = intval($this->session->userdata('uid'));
		if ($uid > 0) {
			// User info
			$data['uid'] = $this->session->userdata('uid');
			$data['name'] = $this->session->userdata('user_name');
			$data['fullname'] = $this->session->userdata('fullname');

			// Views
			$data['main_content'] = 'system_user/success';
			$this->load->vars($data);
			$this->load->view($this->_template);
		}
	}

	public function error_access() {
		$data['main_content'] = 'system_user/error_access';
		$this->load->vars($data);
		$this->load->view($this->_template);
	}

	public function logout(){
		$uid = $this->session->userdata('uid');
		$curent = (int)date('H');
		$redirect = 1;

		if ($curent >= 17) {
			$data = $this->spop($uid);
			$this->load->vars($data);
			$this->load->view('task/modalTask');
			$redirect = 0;
		}

		// Insert into log table
		$this->load->model('hrm/ReportLogModel', 'log');
		$this->load->library('ip');

		$log['uid'] = $uid;
		$log['time'] = time();
		$log['day'] = date('d');
		$log['month'] = date('m');
		$log['year'] = date('Y');
		$log['action'] = 'logout';
		$log['ip'] = $_SERVER['REMOTE_ADDR'];
		$detect = $this->ip->detect_network($_SERVER['REMOTE_ADDR']);
		if ($detect) {
			$log['from'] = 'lan';
		} else {
			$log['from'] = 'internet';
		}
		$this->log->put($log);
		$this->session->sess_destroy();

		redirect(base_url().'home','refresh');
	}
}










