<?php

class BenefitEmployee extends MX_Controller {

    private $template = "iso/template";
    private $_redirect = 'hrm/benefitemployee';
    private $_view = "benefitemployee/";
    private $_table = "mc_benefit_employee";
    private $_uid;
    private $_model;

    function __construct() {
        parent::__construct();
        $this->uid = $this->session->userdata('uid');
        if (!isset($this->uid) OR $this->uid <= 0) {
            redirect(base_url() . '?ref=' . base_url() . "hrm/benefitemployee", 'refresh');
        }
        $this->load->helper('base_helper');
        $this->load->model('hrm/BenefitEmployeeModel', 'benefitemployee');
        $this->_model = $this->benefitemployee;
    }

    public function data() {
        $data['activeEmployee'] = TRUE;
        return $data;
    }

    public function index() {
        /** load data */
        $data = $this->data();

        // LEFT BOX
        $this->load->model('hrm/EmployeeModel', 'employ');
        $this->load->model('setting/DepartmentModel', 'department');

        $data['depart'] = $this->department->get_depart('id,name', '');
        $data['employ'] = $this->employ->get_employ_by_depart();

        /** get uid */
        $uid = (int) $this->input->get('uid');
        if ($uid <= 0)
            redirect(base_url() . 'hrm/employee', 'refresh');

        $data['uid'] = $uid;
        $data['query'] = $this->_model->get(array('employee_id' => $uid));
        $data['actionDel'] = base_url() . $this->_redirect . '/delete';
        $data['main_content'] = $this->_view . "view";

        $this->load->vars($data);
        $this->load->view($this->template);
    }

    public function edit() {
        $uid = $this->input->get('uid');
        if ($uid > 0) {
            $this->load->model('hrm/BenefitEmployeeModel', 'benefitmodels');
            $this->load->model('hrm/EmployeeModel', 'employ');
            $this->load->model('hrm/GroupBenefitModel', 'groupbenefit');
            $this->load->model('setting/BenefitModel', 'benefit');
            $this->load->model('setting/UnitModel', 'unit');
            $this->load->model('setting/DepartmentModel', 'department');
            
            // Employ info
            $data['userInfo'] = $this->employ->get_employ_info($uid);
            $data['depart'] = $this->department->get_depart('id,name', '');
            $data['employ'] = $this->employ->get_employ_by_depart();

            // Get all group benefit
            $data['allGroupBenefit'] = $this->groupbenefit->get_all();
            
            // User benefit
            $data['listId'] = '';
            $data['uid'] = $uid;
            $data['userBenefit'] = $this->benefitemployee->get_benefit_employee($data['userInfo']['id']);
				
            if (!empty($data['userBenefit'])) {
                foreach ($data['userBenefit'] as $pKey => $pBenefit) {
                    $arUB[] = $pBenefit['id'];
                }
                $data['listId'] = implode(',', $arUB);
            } else {
                $data['userBenefit'] = array();
            }

            // All unit
            $data['unit'] = $this->unit->getAllUnit();

            // Navigation
            $data['navi'] = array(array('name' => 'Định mức', 'href' => base_url() . 'hrm/benefitemployee/'),
                array('name' => $data['userInfo']['fullname'], 'href' => base_url() . 'hrm/benefitemployee/edit/' . $uid));

            // Main view
            $data['main_content'] = 'benefitemployee/edit';
            $data['benefit'] = $this->benefitmodels->get_all_benefit();
            
            $this->load->vars($data);
            $this->load->view($this->template);
        }
    }

    public function submit_update() {
        if (isset($_POST['action']) && $_POST['action'] == 'update_benefit') {
        	
            $uid = $this->input->post('uid');
            $this->load->model('BenefitEmployeeModel', 'benefitemploy');
            $arBenefitId = explode(',', $this->input->post('list_benefit'));
            if (!empty($arBenefitId)) {
                foreach ($arBenefitId as $bid) {
                    $up['limitation'] = str_replace('.', '', $this->input->post('limitation-' . $bid));
                    $this->benefitemploy->update($up, 'id', $bid);
                }
            }
            //Thực hiện việc thêm mới
            $arrBenefitN = (isset($_POST['benefit_new']) ? $_POST['benefit_new'] : array());
            $arrNumberN = (isset($_POST['number_new']) ? $_POST['number_new'] : array());
            $arrUnitN = (isset($_POST['unit_new']) ? $_POST['unit_new'] : array());
            $emId = (isset($_POST['emid']) ? $_POST['emid'] : array());
            if (isset($arrBenefitN)) {
                foreach ($arrBenefitN as $key => $value) {
                    if ($arrNumberN[$key] != '') {
                        $data_value[] = array('employee_id' => $emId,
                            'limitation' => $arrNumberN[$key],
                            'benefit_id' => $value,
                            'unit' => $arrUnitN[$key],
                            'active' => 1
                        );
                    }
                }
                if (isset($data_value)) {
                    foreach ($data_value as $key => $value) {
                        $this->db->insert('mc_benefit_employee', $value);
                    }
                }
            }
            redirect(base_url() . 'hrm/benefitemployee/edit?uid=' . $uid);
        } else {
            redirect(base_url() . 'home');
        }
    }

    public function submit_active() {
        if (!$this->input->is_ajax_request()) {
            redirect(base_url() . 'home');
        } else {
            $id = $this->input->post('id');
            if ($id > 0) {
                $this->load->model('BenefitEmployeeModel', 'benefitemploy');
                $active = $this->input->post('active');
                $active = $active - 1;
                $up['active'] = abs($active);
                $this->benefitemploy->update($up, 'id', $id);
            }
        }
    }

    public function update() {
        $id = (int) $this->input->post('id');
        $uid = (int) $this->input->get('uid');

        if ($id <= 0) {
            $this->session->set_flashdata('error', 'Có lỗi mời bạn thử lại lúc khác !');
            redirect(base_url() . $this->_redirect, 'refresh');
        }

        if ($this->db->update($this->_table, $_POST['input'], array('id' => $_POST['id']))) {
            $this->session->set_flashdata('success', 'Bạn đã cập nhật thành công !');
        } else {
            $this->session->set_flashdata('error', 'Có lỗi mời bạn thử lại lúc khác!');
        }
        redirect(base_url() . $this->_redirect . '/?uid=' . $uid, 'refresh');
    }

    public function delete() {
        if ($this->input->is_ajax_request()) {
            $id = (int) $_POST['id'];
            $this->db->delete($this->_table, array('id' => $id));
        }
    }

    public function deletemulti() {
        if ($this->input->is_ajax_request()) {
            $ids = $_POST['ids'];
            $this->db->where_in('id', $ids);
            $this->db->delete($this->_table);
        }
    }

}