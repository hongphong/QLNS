<?php

if (!defined('BASEPATH'))
exit('No direct script access allowed');

class Box extends MX_Controller {
	private $uid = 0;

	public function __construct() {
		parent::__construct();
		$this->load->library('perm');
	}

	public function boxLeftProcess() {
		$menuHtml = '';
		$menuArray = array();

		$module = $this->uri->segment(1);
		$controller = $this->uri->segment(2);
		$function = $this->uri->segment(3);
		if ($module == 'iso' && $controller == 'process') {
			if ($function == 'add') {
				$menuArray[] = array('name' => 'Thêm mới quy trình', 'url' => 'iso/process/add');
			} else if ($function == 'detail') {
				$menuArray[] = array('name' => 'Thêm mới quy trình', 'url' => 'iso/process/add');
				$menuArray[] = array('name' => 'Thêm mới giai đoạn', 'url' => 'iso/process/phase_add/' . $this->uri->segment(4));
			} else if ($function == 'edit') {
				$menuArray[] = array('name' => 'Thêm mới giai đoạn', 'url' => 'iso/process/phase_add/' . $this->uri->segment(4));
			} else if ($function == 'listing') {
				$menuArray[] = array('name' => 'Thêm mới quy trình', 'url' => 'iso/process/add');
			} else if ($function == 'phase_add') {
				$menuArray[] = array('name' => 'Thêm mới giai đoạn', 'url' => 'iso/process/phase_add/' . $this->uri->segment(4));
			} else if ($function == 'phase_detail' || $function == 'phase_edit') {
				$menuArray[] = array('name' => 'Thêm mới bước', 'url' => 'iso/process/add_step/' . $this->uri->segment(4));
			} else if ($function == 'add_step') {
				$menuArray[] = array('name' => 'Thêm mới bước', 'url' => 'iso/process/add_step' . $this->uri->segment(4));
			} else if ($function == 'step_detail' || $function == 'step_edit') {
				$menuArray[] = array('name' => 'Thêm mới bước', 'url' => 'iso/process/add_step' . $this->uri->segment(4));
			}
		}

		/** GENERATE MENU */
		if (!empty($menuArray)) {
			$menuHtml .= '<div align="center" id="menu-add">';
			foreach ($menuArray as $menu) {
				$menuHtml .= '<div class="btt-menu">';
				$menuHtml .= '<div class="left l"></div>';
				$menuHtml .= '<div class="left m">';
				$menuHtml .= '<a href="' . base_url() . $menu['url'] . '"><b>' . $menu['name'] . '</b></a>';
				$menuHtml .= '</div>';
				$menuHtml .= '<div class="left r"></div>';
				$menuHtml .= '</div>';
			}
			$menuHtml .= '</div>';
		}
		return $menuHtml;
	}

	public function boxFuncI() {
		return Box::boxMenu();
      
      $uid =  $this->session->userdata('uid');
      if ($uid != SUPPER_ADMIN) {
         return Box::boxMenu();
      }
      
      $html = '';
		$arFunc = array();

		$module = $this->uri->segment(1);
		$controller = $this->uri->segment(2);
		$function = $this->uri->segment(3);

		/** Notification - NQH **/
		//If this is module notification, get url param for generate module, class, funtion for redirect
		if ($module == 'notification' && isset($_GET['url'])) {
			$url  =  base64_decode($_GET['url']);
			if ($url != '') {
				$arr_url =  explode('/', $url);
				 
				if (isset($arr_url[1]) && isset($arr_url[2])) {
					$module        =  $arr_url[1];
					$controller    =  $arr_url[2];
					if (isset($arr_url[3])) $function   =  $arr_url[3];
				}
			}
		}
		
		$arFuncAvai = array(
		1 => array('id' => 1, 'name' => 'Danh sách dự án', 'url' => base_url() . 'iso/project/list', 'segment_1' => 'iso', 'segment_2' => 'project', 'segment_3' => 'listing'),
		2 => array('id' => 2, 'name' => 'Tất cả công việc', 'url' => base_url() . 'iso/project/detail/' . $this->uri->segment(4), 'segment_1' => 'iso', 'segment_2' => 'project', 'segment_3' => 'detail'),
		3 => array('id' => 3, 'name' => 'Công ty', 'url' => base_url() . 'setting/company', 'segment_1' => 'setting', 'segment_2' => 'company'),
		
		4 => array('id' => 4, 'name' => 'Phòng ban', 'url' => base_url() . 'setting/department', 'segment_1' => 'setting', 'segment_2' => 'department'),
		5 => array('id' => 5, 'name' => 'Chức vụ', 'url' => base_url() . 'setting/position', 'segment_1' => 'setting', 'segment_2' => 'position'),
		6 => array('id' => 6, 'name' => 'Định mức', 'url' => base_url() . 'setting/benefit', 'segment_1' => 'setting', 'segment_2' => 'benefit'),
		7 => array('id' => 7, 'name' => 'Đơn vị tiền', 'url' => base_url() . 'setting/unit', 'segment_1' => 'setting', 'segment_2' => 'unit'),
		8 => array('id' => 8, 'name' => 'Nhân viên', 'url' => base_url() . 'hrm/employee', 'segment_1' => 'hrm', 'segment_2' => 'employee'),
		9 => array('id' => 9, 'name' => 'Hồ sơ', 'url' => base_url() . 'hrm/employeeDegree', 'segment_1' => 'hrm', 'segment_2' => 'employeeDegree'),
		11 => array('id' => 11, 'name' => 'Định mức nhóm', 'url' => base_url() . 'hrm/groupbenefit/', 'segment_1' => 'hrm', 'segment_2' => 'groupbenefit'),
		10 => array('id' => 10, 'name' => 'Định mức vị trí', 'url' => base_url() . 'hrm/humanbenefit/', 'segment_1' => 'hrm', 'segment_2' => 'humanbenefit'),
		
		12 => array('id' => 12, 'name' => 'Chấm công', 'url' => base_url() . 'hrm/reportlog', 'segment_1' => 'hrm', 'segment_2' => 'reportlog'),
		13 => array('id' => 13, 'name' => 'Tổng hợp lương', 'url' => base_url() . 'hrm/salary', 'segment_1' => 'hrm', 'segment_2' => 'salary'),
		14 => array('id' => 14, 'name' => 'Thông tin chung', 'url' => base_url() . 'iso/project/info/' . $this->uri->segment(4), 'segment_1' => 'iso', 'segment_2' => 'project', 'segment_3' => 'info'),
		17 => array('id' => 17, 'name' => 'Công việc', 'url' => base_url() . 'iso/phase/detail/' . $this->uri->segment(4), 'segment_1' => 'iso', 'segment_2' => 'phase', 'segment_3' => 'detail'),
		18 => array('id' => 18, 'name' => 'Công việc', 'url' => base_url() . 'iso/step/detail/' . $this->uri->segment(4), 'segment_1' => 'iso', 'segment_2' => 'step', 'segment_3' => 'detail'),
		15 => array('id' => 15, 'name' => 'Thông tin chung', 'url' => base_url() . 'iso/step/info/' . $this->uri->segment(4), 'segment_1' => 'iso', 'segment_2' => 'step', 'segment_3' => 'info'),
		16 => array('id' => 16, 'name' => 'Thông tin chung', 'url' => base_url() . 'iso/phase/info/' . $this->uri->segment(4), 'segment_1' => 'iso', 'segment_2' => 'phase', 'segment_3' => 'info'),
		19 => array('id' => 19, 'name' => 'Thêm mới dự án', 'url' => base_url() . 'iso/project/add', 'segment_1' => 'iso', 'segment_2' => 'project', 'segment_3' => 'add'),
		20 => array('id' => 20, 'name' => 'Thêm mới giai đoạn', 'url' => base_url() . 'iso/phase/add', 'segment_1' => 'iso', 'segment_2' => 'phase', 'segment_3' => 'add'),
		21 => array('id' => 21, 'name' => 'Thêm mới bước', 'url' => base_url() . 'iso/step/add', 'segment_1' => 'iso', 'segment_2' => 'step', 'segment_3' => 'add'),
		24 => array('id' => 24, 'name' => 'Tài liệu', 'url' => base_url() . 'iso/project/document/' . $this->uri->segment(4), 'segment_1' => 'iso', 'segment_2' => 'project', 'segment_3' => 'document'),
		25 => array('id' => 25, 'name' => 'Ngày phép', 'url' => base_url() . 'hrm/reportlog', 'segment_1' => 'hrm', 'segment_2' => 'reportlog'),
		26 => array('id' => 26, 'name' => 'Quản lý tài sản', 'url' => base_url() . 'facility', 'segment_1' => 'facility', 'segment_2' => ''),
		27 => array('id' => 27, 'name' => 'Lập kế hoạch', 'url' => base_url() . 'iso/project/process/' . $this->uri->segment(4), 'segment_1' => 'iso', 'segment_2' => 'project', 'segment_3' => 'process'),
		28 => array('id' => 28, 'name' => 'Đơn vị', 'url' => base_url() . 'kpi/unit', 'segment_1' => 'kpi', 'segment_2' => 'unit'),
		29 => array('id' => 29, 'name' => 'Nhóm tiêu chí', 'url' => base_url() . 'kpi/group', 'segment_1' => 'kpi', 'segment_2' => 'group'),
		30 => array('id' => 30, 'name' => 'Tiêu chí', 'url' => base_url() . 'kpi/product', 'segment_1' => 'kpi', 'segment_2' => 'product'),
		31 => array('id' => 31, 'name' => 'Mẫu', 'url' => base_url() . 'kpi/models', 'segment_1' => 'kpi', 'segment_2' => 'models'),
		32 => array('id' => 32, 'name' => 'Đánh giá', 'url' => base_url() . 'kpi/report', 'segment_1' => 'kpi', 'segment_2' => 'report'),
		33 => array('id' => 33, 'name' => 'Quản lý đánh giá', 'url' => base_url() . 'kpi/view', 'segment_1' => 'kpi', 'segment_2' => 'view'),
		34 => array('id' => 34, 'name' => 'Lịch tài sản', 'url' => base_url() . 'facility/calendar', 'segment_1' => 'facility', 'segment_2' => 'calendar'),
		35 => array('id' => 35, 'name' => 'KPI năm', 'url' => base_url() . 'kpi/kyear', 'segment_1' => 'kpi', 'segment_2' => 'kyear'),
		36 => array('id' => 36, 'name' => 'KPI tháng', 'url' => base_url() . 'kpi/kmonth', 'segment_1' => 'kpi', 'segment_2' => 'kmonth'),
		80 => array('id' => 80, 'name' => 'Khách hàng', 'url' => base_url().'customer/company', 'segment_1' => 'customer', 'segment_2' => 'company'),
		81 => array('id' => 81, 'name' => 'Phòng ban', 'url' => base_url().'customer/department', 'segment_1' => 'customer', 'segment_2' => 'department'),
		82 => array('id' => 82, 'name' => 'Ngành', 'url' => base_url().'customer/career', 'segment_1' => 'customer', 'segment_2' => 'career'),
		//83 => array('id' => 83, 'name' => 'Dự án', 'url' => base_url().'customer/project', 'segment_1' => 'customer', 'segment_2' => 'project'),
		84 => array('id' => 84, 'name' => 'Chào giá', 'url' => base_url().'customer/offer', 'segment_1' => 'customer', 'segment_2' => 'offer'),
		85 => array('id' => 85, 'name' => 'Hợp đồng', 'url' => base_url().'customer/contract', 'segment_1' => 'customer', 'segment_2' => 'contract'),
		87 => array('id' => 87, 'name' => 'Phân quyền', 'url' => base_url().'setting/permission', 'segment_1' => 'setting', 'segment_2' => 'permission'),
		88 => array('id' => 88, 'name' => 'Tin đấu thầu', 'url' => base_url().'opportunity/view', 'segment_1' => 'opportunity', 'segment_2' => 'view|add'),
		89 => array('id' => 89, 'name' => 'Danh mục đấu thầu', 'url' => base_url().'opportunity/category_list', 'segment_1' => 'opportunity', 'segment_2' => 'category_list'),
		90 => array('id' => 90, 'name' => 'Thống kê dự án', 'url' => base_url() . 'iso/project/statistic/' . $this->uri->segment(4), 'segment_1' => 'iso', 'segment_2' => 'project', 'segment_3' => 'statistic'),
		91 => array('id' => 91, 'name' => 'Chào giá', 'url' => base_url() . 'iso/project/offer/' . $this->uri->segment(4), 'segment_1' => 'iso', 'segment_2' => 'project', 'segment_3' => 'offer'),
		92 => array('id' => 92, 'name' => 'Hợp đồng', 'url' => base_url() . 'iso/project/contract/' . $this->uri->segment(4), 'segment_1' => 'iso', 'segment_2' => 'project', 'segment_3' => 'contract'),
		94 => array('id' => 94, 'name' => 'Quy trình', 'url' => base_url() . 'iso/process/listing', 'segment_1' => 'iso', 'segment_2' => 'process', 'segment_3' => 'listing'),
		//96 => array('id' => 96, 'name' => 'Danh mục quy trình', 'url' => base_url() . 'iso/process/category', 'segment_1' => 'iso', 'segment_2' => 'process', 'segment_3' => 'category|addcat'),
		97 => array('id' => 97, 'name' => 'Cập nhật', 'url' => base_url() . 'iso/project/edit/' . $this->uri->segment(4), 'segment_1' => 'iso', 'segment_2' => 'project', 'segment_3' => 'edit'),
		98 => array('id' => 98, 'name' => 'Quy trình', 'url' => base_url() . 'iso/project/changeconcept/' . $this->uri->segment(4), 'segment_1' => 'iso', 'segment_2' => 'project', 'segment_3' => 'changeconcept'),
		100 => array('id' => 100, 'name' => 'Tài liệu chung', 'url' => base_url() . 'document/view', 'segment_1' => 'document', 'segment_2' => 'view', 'segment_3' => ''),
		102 => array('id' => 102, 'name' => 'Tài liệu dự án', 'url' => base_url() . 'document/prodoc', 'segment_1' => 'document', 'segment_2' => 'prodoc'),
		86 => array('id' => 86, 'name' => 'Hôm nay', 'url' => base_url().'work/today', 'segment_1' => 'work', 'segment_2' => 'today'),
		104 => array('id' => 104, 'name' => 'Tất cả', 'url' => base_url().'work/all', 'segment_1' => 'work', 'segment_2' => 'all'),
		106 => array('id' => 106, 'name' => 'Quá hạn', 'url' => base_url().'work/expired', 'segment_1' => 'work', 'segment_2' => 'expired'),
		108 => array('id' => 108, 'name' => 'Sơ đồ tổ chức', 'url' => base_url() . 'setting/orgchart', 'segment_1' => 'setting', 'segment_2' => 'orgchart'),
		110 => array('id' => 110, 'name' => 'Quản lý sản phẩm', 'url' => base_url() . 'products', 'segment_1' => 'products', 'segment_2' => '')
		);

		$arFuncAvaiII = array(
		1 => array('name' => 'Thêm mới', 'url' => base_url() . $module . '/' . ($controller . '/') . 'add', 'segment_3' => 'add'),
		2 => array('name' => 'Danh sách', 'url' => base_url() . $module . '/' . $controller, 'segment_3' => ''),
		3 => array('name' => 'Thêm mới', 'url' => base_url() . $module . '/' . ($controller . '/') . 'add' . ((isset($_GET['uid'])) ? '?uid=' . $_GET['uid'] : ''), 'segment_3' => 'add'),
		4 => array('name' => 'Danh sách', 'url' => base_url() . $module . '/' . $controller . ((isset($_GET['uid'])) ? '?uid=' . $_GET['uid'] : ''), 'segment_3' => ''),
		5 => array('name' => 'Lương', 'url' => base_url() . $module . '/' . $controller, 'segment_3' => ''),
		6 => array('name' => 'Chi phí', 'url' => base_url() . $module . '/' . $controller . '/cost', 'segment_3' => 'cost'),
		7 => array('name' => 'Tổng hợp', 'url' => base_url() . $module . '/' . $controller . '/total', 'segment_3' => 'total'),
		13 => array('name' => 'Thêm mới', 'url' => base_url() . $module . '/add', 'segment_3' => ''),
		14 => array('name' => 'Danh sách', 'url' => base_url() . $module . '/', 'segment_3' => ''),
		8 => array('name' => 'Danh sách mượn', 'url' => base_url() . $module . '/total_borrow', 'segment_3' => ''),
		9 => array('name' => 'Chưa sử dụng', 'url' => base_url() . $module . '/usefull', 'segment_3' => ''),
		10 => array('name' => 'Đã sử dụng', 'url' => base_url() . $module . '/notuse', 'segment_3' => ''),
		12 => array('name' => 'Hỏng', 'url' => base_url() . $module . '/broken', 'segment_3' => ''),
		11 => array('name' => 'Mượn tài sản', 'url' => base_url() . $module . '/user_borrow', 'segment_3' => '', 'class' => 'fancybox_add_borrow','id'=>'fancybox_add_borrow'),
		15 => array('name' => 'Hôm nay', 'url' => base_url() . $module . '/calendar/today', 'segment_3' => ''),
		16 => array('name' => 'Tuần', 'url' => base_url() . $module . '/calendar/week', 'segment_3' => ''),
		17 => array('name' => 'Tháng', 'url' => base_url() . $module . '/calendar/month', 'segment_3' => ''),
		18 => array('name' => 'Giao hàng', 'url' => base_url().$module.'/'.$controller.'/delivery_add', 'segment_3' => 'delivery_add'),
		19 => array('name' => 'DS giao hàng', 'url' => base_url().$module.'/'.$controller.'/delivery_list', 'segment_3' => 'delivery_list'),
		20 => array('name' => 'Thanh toán', 'url' => base_url().$module.'/'.$controller.'/payment_new', 'segment_3' => 'payment_new'),
		30 => array('name' => 'DS Thanh toán', 'url' => base_url().$module.'/'.$controller.'/payment_list', 'segment_3' => 'payment_list'),
		21 => array('name' => 'Thêm nhóm', 'url' => base_url().$module.'/permission/addgroup', 'segment_3' => 'addgroup'),
		22 => array('name' => 'DS nhóm', 'url' => base_url().$module.'/permission/group', 'segment_3' => 'group'),
		23 => array('name' => 'DS account', 'url' => base_url().$module.'/permission/index', 'segment_3' => 'index'),
		24 => array('name' => 'Danh sách', 'url' => base_url().$module.'/view', 'segment_2' => 'view'),
		25 => array('name' => 'Danh sách', 'url' => base_url().$module.'/category_list', 'segment_2' => 'category_list'),
		26 => array('name' => 'Thêm mới', 'url' => base_url().$module.'/category_add', 'segment_2' => 'category_add', 'id' => 'op_cate_add'),
		27 => array('name' => 'Thêm mới', 'url' => base_url().$module.'/add', 'segment_2' => 'add'),
		28 => array('name' => 'DS module', 'url' => base_url().$module.'/permission/module_list', 'segment_3' => 'module_list'),
		29 => array('name' => 'Thêm module', 'url' => base_url().$module.'/permission/module_add', 'segment_3' => 'module_add'),
		//30 => array('name' => 'Thêm dự án', 'url' => base_url().'iso/project/add', 'segment_3' => 'add'),
		31 => array('name' => 'Danh sách', 'url' => base_url().'iso/process/category', 'segment_3' => 'category'),
		32 => array('name' => 'Thêm mới', 'url' => base_url().'iso/process/addcat', 'segment_3' => 'addcat'),
		33 => array('name' => 'Thêm mới nhóm KH', 'url' => base_url() . $module . '/' . $controller . '/' . 'group_add', 'segment_3' => 'group_add'),
		34 => array('name' => 'Danh sách nhóm KH', 'url' => base_url() . $module . '/' . $controller . '/' . 'group_list', 'segment_3' => 'group_list'),
		35 => array('name' => 'Ngày phép tháng', 'url'=>base_url() . $module . '/' . $controller . '/' . 'dayoff','segment_3'=>'dayoff'),
		36 => array('name' => 'Ngày phép năm', 'url'=>base_url() . $module . '/' . $controller . '/' . 'dayoffyear','segment_3'=>'dayoffyear'),
		
		38 => array('name' => 'Quá trình thực hiện', 'url' => base_url().$module.'/prodoc/process/'.$this->uri->segment(4), 'segment_3' => 'process'),
		40 => array('name' => 'Thống kê dự án', 'url' => base_url().$module.'/prodoc/statistic/'.$this->uri->segment(4), 'segment_3' => 'statistic'),
		42 => array('name' => 'Tài liệu', 'url' => base_url().$module.'/prodoc/document/'.$this->uri->segment(4), 'segment_3' => 'document'),
		44 => array('name' => 'Chào giá', 'url' => base_url().$module.'/prodoc/offer/'.$this->uri->segment(4), 'segment_3' => 'offer'),
		46 => array('name' => 'Hợp đồng', 'url' => base_url().$module.'/prodoc/contract/'.$this->uri->segment(4), 'segment_3' => 'contract'),
		48 => array('name' => 'Thêm mới', 'url' => base_url().'products/add', 'segment_2' => 'add'),
		50 => array('name' => 'Danh sách', 'url' => base_url().'products/view', 'segment_2' => 'view')
		);
		/** Tiếp theo key là 31 **/

		$arRelation = array(8 => array(2, 1), 9 => array(2, 1), 10 => array(2, 1), 11 => array(2, 1), 3 => array(2, 1), 4 => array(2, 1), 5 => array(2, 1), 6 => array(2, 1), 7 => array(2, 1), 13 => array(5, 6, 7), 3 => array(2, 1), 4 => array(2, 1), 5 => array(2, 1), 6 => array(2, 1), 7 => array(2, 1), 26 => array(13, 14, 8, 9, 10, 12, 11),
		28 => array(2, 1), 29 => array(2, 1), 30 => array(2, 1), 31 => array(2, 1), 33 => array(2, 1),34=>array(15), 35 => array(2, 1), 36 => array(2, 1),
		85 => array(1, 2, 18, 19, 20, 30), 80 => array(1, 2, 33, 34), 81 => array(1, 2), 82 => array(1, 2), 83 => array(30, 2), 84 => array(1, 2),
		87 => array(23, 22, 21, 29), 88 => array(24, 27), 89 => array(25, 26), 96 => array(31, 32),25=>array(35,36), 102 => array(38, 40, 42, 44, 46),
		110 => array(50, 48));
		
		// PROCESS
		if ($module == 'iso' && $controller == 'process') {
			if ($function == 'listing' || $function == 'category' || $function == 'addcat') {
				foreach ($arFuncAvai as $f) {
					if (in_array($f['id'], array(94))) {
						$arFunc[] = $f;
					}
				}
			}
		}
		
		// PROJECT
		if ($module == 'iso' && $controller == 'project') {
			if ($function == 'listing') {
				$arFunc[] = $arFuncAvai[1];
			} else if ($function == 'detail' || $function == 'info' || $function == 'document' || $function == 'process' || $function == 'statistic' || $function == 'offer' || $function == 'contract' || $function == 'edit' || $function == 'changeconcept') {
				foreach ($arFuncAvai as $f) {
					if (in_array($f['id'], array(2, 14, 24, 27, 90, 91, 92, 97, 98))) {
						$arFunc[] = $f;
					}
				}
			} else if ($function == 'add') {
				foreach ($arFuncAvai as $f) {
					if (in_array($f['id'], array(19))) {
						$arFunc[] = $f;
					}
				}
			}
		}
		
		// PHASE
		if ($module == 'iso' && $controller == 'phase') {
			if ($function == 'listing') {

			} else if ($function == 'detail' || $function == 'info') {
				foreach ($arFuncAvai as $f) {
					if (in_array($f['id'], array(16, 17))) {
						$arFunc[] = $f;
					}
				}
			} else if ($function == 'add') {
				foreach ($arFuncAvai as $f) {
					if (in_array($f['id'], array(20))) {
						$arFunc[] = $f;
					}
				}
			}
		}

		// STEP
		if ($module == 'iso' && $controller == 'step') {
			if ($function == 'listing') {

			} else if ($function == 'detail' || $function == 'info') {
				foreach ($arFuncAvai as $f) {
					if (in_array($f['id'], array(15, 18))) {
						$arFunc[] = $f;
					}
				}
			} else if ($function == 'add') {
				foreach ($arFuncAvai as $f) {
					if (in_array($f['id'], array(21))) {
						$arFunc[] = $f;
					}
				}
			}
		}

		// SETTINGS
		if ($module == 'setting') {
			foreach ($arFuncAvai as $f) {
				if (in_array($f['id'], array(3, 4, 5, 6, 7, 87, 108))) {
					$arFunc[] = $f;
				}
			}
		}
		
		// DOCUMENT
		if ($module == 'document') {
			foreach ($arFuncAvai as $f) {
				if (in_array($f['id'], array(100, 102))) {
					$arFunc[] = $f;
				}
			}
		}

		// HRM
		if ($module == 'hrm') {
			foreach ($arFuncAvai as $f) {
				if (in_array($f['id'], array(8, 9, 11, 13, 25, 108))) {
					$arFunc[] = $f;
				}
			}
		}

		// KPI
		if ($module == 'kpi') {
			foreach ($arFuncAvai as $f) {
				if (in_array($f['id'], array(28, 29, 30, 31, 35, 36))) {
					$arFunc[] = $f;
				}
			}
		}

		// FACILITY
		if ($module == 'facility') {
			foreach ($arFuncAvai as $f) {
				if (in_array($f['id'], array(26, 34))) {
					$arFunc[] = $f;
				}
			}
		}

		// CUSTOMER
		if ($module == 'customer') {
			foreach ($arFuncAvai as $f) {
				if (in_array($f['id'], array(80, 82, 83, 84, 85))) {
					$arFunc[] = $f;
				}
			}
		}

		// WORK
		if ($module == 'work') {
			foreach ($arFuncAvai as $f) {
				if (in_array($f['id'], array(86, 104, 106))) {
					$arFunc[] = $f;
				}
			}
		}

		// OPPORTUNITY
		if ($module == 'opportunity') {
			foreach ($arFuncAvai as $f) {
				if (in_array($f['id'], array(88, 89))) {
					$arFunc[] = $f;
				}
			}
		}
		
		// PRODUCTS
		if ($module == 'products') {
			foreach ($arFuncAvai as $f) {
				if (in_array($f['id'], array(110))) {
					$arFunc[] = $f;
				}
			}
		}

		/** GENERATE FUNCTION MENU */
		$funcId = 0;
		if (!empty($arFunc)) {
			$html .= '<ul class="menu-function ds-process">';
			foreach ($arFunc as $func) {
				$class = '';
				if ($func['segment_2'] != '') {
					$arTemp_2 = explode('|', $func['segment_2']);
					if (!empty($arTemp_2)) {
						foreach ($arTemp_2 as $temp_2) {
							if ($func['segment_1'] == $module && $temp_2 == $controller) {
								if (isset($func['segment_3'])) {
									$arTemp = explode('|', $func['segment_3']);
									if (!empty($arTemp)) {
										foreach ($arTemp as $temp) {
											if ($temp == $function) {
												$class = 'active';
												$funcId = $func['id'];
											}
										}
									}
								} else {
									$class = 'active';
		                            $funcId = $func['id'];
		                        }
		                    }
                		}
                	}
                } else {
                    $class = 'active';
                    $funcId = $func['id'];
                }
                $html .= '<li class="' . $class . '">';
                $html .= '<a href="' . $func['url'] . '">';
                $html .= '<div class="p1">';
                $html .= '<div class="p2">';
                $html .= '<div class="p3">';
                $html .= '<b>' . $func['name'] . '</b>';
                $html .= '</div>';
                $html .= '</div>';
                $html .= '</div>';
                $html .= '</a>';
                $html .= '</li>';
            }
            $html .= '</ul>';
        }

        /** GENERATE FUNCTION MENU II */
        $htmlII = '';
        if (!empty($arRelation[$funcId])) {
            $htmlII .= '<div class="menu-sub-function">';
            $htmlII .= '<ul class="ul-menu-sf">';
            $c = 0;
            foreach ($arRelation[$funcId] as $key) {
                $c++;
                $class = '';
                $id = (isset($arFuncAvaiII[$key]['id']) ? $arFuncAvaiII[$key]['id'] : '');
                $class = (isset($arFuncAvaiII[$key]['class']) ? $arFuncAvaiII[$key]['class'] : '');
                if ($c < count($arRelation[$funcId])) {
                	$class .= ' bright ';
                }
				
                if ($this->uri->segment(3) != '' && isset($arFuncAvaiII[$key]['segment_3'])) {
                	if ($arFuncAvaiII[$key]['segment_3'] == $this->uri->segment(3)) {
	                	$class .= ' active ';
	                }
                } else {
                	if ($this->uri->segment(2) != '' && isset($arFuncAvaiII[$key]['segment_2'])) {
	                	if ($arFuncAvaiII[$key]['segment_2'] == $this->uri->segment(2)) {
		                	$class .= ' active ';
		                }
                	}
                }
				
                $htmlII .= '<li class="' . $class . '">';
                $htmlII .= '<a id="'. $id .'" class="'. $class .'" href="' . $arFuncAvaiII[$key]['url'] . '">' . $arFuncAvaiII[$key]['name'] . '</a>';
                $htmlII .= '</li>';
            }
            $htmlII .= '</ul>';
            $htmlII .= '</div>';
        }
        return array($html, $htmlII);
    }

    public function boxLeft() {
        $uid = $this->session->userdata('uid');
        if ($uid > 0) {
            $menuHtml = '';
            $menuArray = array();
            $module = $this->uri->segment(1);
            $controller = $this->uri->segment(2);
            $function = $this->uri->segment(3);
			
            if ($module == 'iso') {
            
	            // PROJECT
	            if ($controller == 'project') {
	                $groupUserType = $this->session->userdata('group_type');
	                if (!$groupUserType) {
	                    $temp = $this->perm->get_perm_group();
	                    $groupUserType = $temp['type'];
	                }
					
	                // Head department 
	                //if ($groupUserType == 'project_full' || $groupUserType == 'root' || $groupUserType == 'project_seller') {
	                    $menuArray[] = array('name' => 'Thêm mới dự án', 'url' => 'iso/project/add');
	                //}
					
	                // Add
	                if ($function == 'add') {
	                    
	                }
	
	                // Listing
	                if ($function == 'listing') {
	                    
	                }
	
	                // Detail && Edit
	                if ($function == 'detail' || $function == 'edit' || $function == 'document' || $function == 'process' || $function == 'offer' || $function == 'contract' || $function == 'statistic') {
	                    $projectId = $this->uri->segment(4);
	                    if ($projectId > 0) {
	                        $this->load->model('iso/ProjectModel', 'projectmain');
	                        $isPM = $this->projectmain->is_manager($projectId, $uid);
	                        if ($isPM) {
	                            $menuArray[] = array('name' => 'Thêm mới giai đoạn', 'url' => 'iso/phase/add?project_id=' . $projectId);
	                        }
	                    }
	                }
	            }
	
	            // PHASE
	            if ($controller == 'phase') {
	                // Add
	                if ($function == 'add') {
	                    $projectId = intval($_GET['project_id']);
	                    if ($projectId > 0) {
	                        $menuArray[] = array('name' => 'Thêm mới giai đoạn', 'url' => 'iso/phase/add?project_id=' . $projectId);
	                    }
	                }
					
	                // Detail && Edit && Info
	                if ($function == 'detail' || $function == 'edit' || $function == 'info') {
	                    $phaseId = $this->uri->segment(4);
	                    if ($phaseId > 0) {
	                        $temp = $this->phase->get_phase('project_id', 'id = ' . $phaseId, '1');
	                        $phaseInfo = $temp[0];
							
	                        $isPhaseManager = $this->phase->is_manager($phaseId, $uid);
	                        $isProjectManager = $this->project->is_manager($phaseInfo['project_id'], $uid);
							
	                        if ($isProjectManager) {
	                            $menuArray[] = array('name' => 'Thêm mới giai đoạn', 'url' => 'iso/phase/add?project_id=' . $phaseInfo['project_id']);
	                            $menuArray[] = array('name' => 'Thêm mới bước', 'url' => 'iso/step/add?phase_id=' . $phaseId);
	                        }
	                    }
	                }
	            }
	
	            // STEP
	            if ($controller == 'step') {
	                // Add
	                if ($function == 'add') {
	                    $phaseId = intval($_GET['phase_id']);
	                    if ($phaseId > 0) {
	                        $menuArray[] = array('name' => 'Thêm mới bước', 'url' => 'iso/phase/add?phase_id=' . $phaseId);
	                    }
	                }
	
	                // Detail && Edit
	                if ($function == 'detail' || $function == 'edit' || $function == 'info') {
	                    $stepId = $this->uri->segment(4);
	                    if ($stepId > 0) {
	                        $temp = $this->step->get_step('phase_id', 'id = ' . $stepId, '1');
	                        $stepInfo = $temp[0];
	
	                        $isPhaseManager = $this->phase->is_manager($stepInfo['phase_id'], $uid);
	                        if ($isPhaseManager) {
	                            $menuArray[] = array('name' => 'Thêm mới bước', 'url' => 'iso/step/add?phase_id=' . $stepInfo['phase_id']);
	                        }
	                    }
	                }
	            }
            }

            /** GENERATE MENU */
            if (!empty($menuArray)) {
                $menuHtml .= '<div align="center" id="menu-add">';
                foreach ($menuArray as $menu) {
                    $menuHtml .= '<div class="btt-menu">';
                    $menuHtml .= '<div class="left l"></div>';
                    $menuHtml .= '<div class="left m">';
                    $menuHtml .= '<a href="' . base_url() . $menu['url'] . '"><b>' . $menu['name'] . '</b></a>';
                    $menuHtml .= '</div>';
                    $menuHtml .= '<div class="left r"></div>';
                    $menuHtml .= '</div>';
                }
                $menuHtml .= '</div>';
            }
            return $menuHtml;
        }
    }

    // SHOW MESSAGE
    public function showMessage($labelError='error', $labelSuccess='success') {
        if ($this->session->flashdata($labelError)):
            print '<div id="display_error" style="margin: 0px;">
				  ' . $this->session->flashdata($labelError) . '
			  </div>';
        endif;
        if ($labelError != 'errac')
        if ($this->session->flashdata($labelSuccess)):
            print '<div id="success">
				  ' . $this->session->flashdata($labelSuccess) . '
			  </div>';
        endif;
    }
    
    
   /**
    * Box::boxMenu() - NQH
    * 
    * @return
    */
   function boxMenu() {
      //Get controller
      $module     =  $this->uri->segment(1);
      $controller =  $this->router->class;
      $function   =  $this->router->method;
      $uid        =  $this->session->userdata('uid');
      
//      echo  $module . '<br>';
//      echo  $controller . '<br>';
//      echo  $function . '<br>';
      
      $arr_controller   =  array();
      $arr_function     =  array();
      
      if ($uid != SUPPER_ADMIN) {
         $db_sl   =  $this->db->query("SELECT fun_id, fun_name, fun_alias, con_id, con_name, con_alias
                                       FROM sys_user_permission
                                       STRAIGHT_JOIN sys_functions ON(uspe_function_id = fun_id)
                                       STRAIGHT_JOIN sys_controllers ON(fun_controller_id = con_id)
                                       STRAIGHT_JOIN sys_modules ON(con_module_id = id)
                                       WHERE uspe_user_id = $uid AND fun_show = 1 AND con_show = 1 AND alias = '$module'");
         $result  =  $db_sl->result_array();
         if (!empty($result)) {
            foreach ($result as $row) {
               if (!isset($arr_controller[$row['con_id']])) {
                  $arr_controller[$row['con_id']]  =  $row;
               }  //end if
               if ($row['con_alias'] == $controller) $arr_function[] =  $row;
            }  //end foreach
         }  //end if
      }  //end if
      else {
         //Super admin
         $db_sl   =  $this->db->query("SELECT *
                                       FROM sys_controllers
                                       STRAIGHT_JOIN sys_modules ON(con_module_id = id)
                                       WHERE alias = '$module' AND con_show = 1");
         $arr_controller  =  $db_sl->result_array();
         
         //Super admin
         $db_sl   =  $this->db->query("SELECT *
                                       FROM sys_functions
                                       STRAIGHT_JOIN sys_controllers ON(fun_controller_id = con_id)
                                       WHERE con_alias = '$controller' AND fun_show = 1");
         $arr_function  =  $db_sl->result_array();
      }
      
//      print_r($arr_controller);
//      print_r($arr_function);
      $html_controller  =  '';
      if (!empty($arr_controller)) {
			$html_controller .= '<ul class="menu-function ds-process">';
			foreach ($arr_controller as $con) {
			   
				$class = $controller == $con['con_alias'] ? 'active' : '';
				$html_controller .= '<li class="' . $class . '">';
            $html_controller .= '<a href="' . base_url() . $module . '/' . $con['con_alias'] . '/">';
            $html_controller .= '<div class="p1">';
            $html_controller .= '<div class="p2">';
            $html_controller .= '<div class="p3">';
            $html_controller .= '<b>' . $con['con_name'] . '</b>';
            $html_controller .= '</div>';
            $html_controller .= '</div>';
            $html_controller .= '</div>';
            $html_controller .= '</a>';
            $html_controller .= '</li>';
         }
         $html_controller .= '</ul>';
      }

        /** GENERATE FUNCTION MENU II */
      //Mot so URL phai truyen them tham so ID
      //Tam thoi chua co time thi khai bao array the nay
      //Luc nao sua lai thi check tu truong fun_add_segment
      $arr_add_segment  =  array(
                                 'isoproject' => array('info' => 4, 'document' => 4, 'process' => 4, 'statistic' => 4, 'offer' => 4, 'contract' => 4, 'edit' => 4, 'changeconcept' => 4)
                                 );
      
      $html_function  =  '';
      if (!empty($arr_function)) {
         $html_function .= '<div class="menu-sub-function">';
         $html_function .= '<ul class="ul-menu-sf">';
         $total   =  count($arr_function);
         $c       =  0;
         foreach ($arr_function as $fun) {
            $class = '';
            $c++;
            if ($c < $total) {
            $class .= 'bright';
            }
            
            if ($function == $fun['fun_alias']) $class .= ' active';
            $href =  base_url() . $module . '/' . $fun['con_alias'] . '/' . $fun['fun_alias'] . '/';
            
            if (isset($arr_add_segment[$module . $controller])){
               $f =  $arr_add_segment[$module . $controller];
               
               if (isset($f[$fun['fun_alias']])) $href .= $this->uri->segment($f[$fun['fun_alias']]);
            }
            
            $html_function .= '<li class="' . $class . '">';
            $html_function .= '<a id="'. $fun['fun_id'] .'" class="'. $class .'" href="' . $href . '">' . $fun['fun_name'] . '</a>';
            $html_function .= '</li>';
         }
         $html_function .= '</ul>';
         $html_function .= '</div>';
      }
      
      
      return array($html_controller, $html_function);
      
   }

}

