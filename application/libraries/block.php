<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Block extends MX_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function boxRight() {
		/* danh sách công ty */
		$this->load->model('setting/CompanyModel', 'company');
		$company = $this->company->get();

		/* danh sách phòng ban */
		$this->load->model('setting/DepartmentModel', 'depart');
		$depart = $this->depart->get_all_category();

		$html = '';
		foreach($company as $row):
		if($row->status == 1):
		$html .= '<li>';
		else:
		$html .= '<li class="closed">';
		endif;
			
		$html .= $row->name;
		/* Hiển thị phòng ban thuộc công ty */
		if(count($depart)> 0 && is_array($depart)):
		$html .= '<ul>';
		foreach($depart as $rows):
		if($rows->parent_id == 0):
		$html .= '<li>';
		$html .= '<a href="">'.$rows->name.'</a>';
		$html .= '<ul>';
		$html .= Block::getEmpolyee($rows->id, $row->id);
		foreach($depart as $rowss):
		if($rowss->parent_id == $rows->id):
		$html .= '<li class="closed">';
		$html .= '<a href="">'.$rowss->name.$rowss->id.'</a>';
		$html .= '<ul>';
		$html .= Block::getEmpolyee($rowss->id, $row->id);
		foreach($depart as $rowsss):
		if($rowsss->parent_id == $rowss->id):
		$html .= '<li class="closed">';
		$html .= '<a href="">'.$rowsss->name.'</a>';
		$html .= Block::getEmpolyeeEnd($rowsss->id, $row->id);
		$html .= '</li>';
		endif;
		endforeach;
		$html .= '</ul>';
		$html .= '</li>';
		endif;
		endforeach;
		$html .= '</ul>';
		$html .= '</li>';
		endif;
		endforeach;
		$html .= '</ul>';
		endif;
		/* end */
		$html .= '</li>';
		endforeach;
		return $html;
	}

	private function getEmpolyee($department_id, $company_id){
		/* danh sách nhân viên */
		$this->load->model('hrm/EmployeeModel', 'employee');
		$employee = $this->employee->getAll();

		$array_employee = '';
		$str = '';

		foreach($employee as $row):
		if($row->department_id == $department_id && $row->company_id == $company_id){
			$array_employee .= '<li id="user"><a href="">'.$row->name.'</a></li>';
		}
		endforeach;
		if($array_employee != '')
		$str = $array_employee;
			
		return $str;
	}

	private function getEmpolyeeEnd($department_id, $company_id){
		/* danh sách nhân viên */
		$this->load->model('hrm/EmployeeModel', 'employee');
		$employee = $this->employee->getAll();

		$array_employee = '';
		$str			= '';

		foreach($employee as $row):
		if($row->department_id == $department_id && $row->company_id == $company_id){
			$array_employee .= '<li id="user"><a href="">'.$row->name.'</a></li>';
		}
		endforeach;
		if($array_employee != '')
		$str = '<ul>'.$array_employee.'</ul>';
			
		return $str;
	}
}