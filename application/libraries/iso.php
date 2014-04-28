<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Iso {
	protected $_CI;
	private $_uid = 0;

	function __construct() {
		$this->_CI 	=& get_instance();
		$this->_CI->load->database();
		$this->_CI->load->library('session');
		$this->_uid = $this->_CI->session->userdata('uid');
	}


	// Check project has no phase
	function checkEmptyProject() {
		$sql = "SELECT id FROM iso_project";
		$db = $this->_CI->db->query($sql);
		$data = $db->result_array();
		if (!empty($data)) {
			foreach ($data as $item) {
				$pSql = "SELECT id FROM iso_phase WHERE project_id = ".$item['id'];
				$dbP = $this->_CI->db->query($pSql);
				if ($dbP->num_rows() <= 0) {
					$this->_CI->db->where('id', $item['id']);
					$this->_CI->db->update('iso_project', array('status' => 100));
				}
			}
		}
	}

	function get_system_modules() {
		//Super admin
		if ($this->_uid == 1) {
			$sql = "SELECT * FROM sys_modules WHERE status = 1";
			$db = $this->_CI->db->query($sql);
			return $db->result('array');
		}
		//Normal account
		$module   =  array();
		$db_sl =  $this->_CI->db->query("SELECT DISTINCT(con_module_id)
                                        FROM sys_user_permission
                                        STRAIGHT_JOIN sys_functions ON (fun_id = uspe_function_id)
                                        STRAIGHT_JOIN sys_controllers ON (con_id = fun_controller_id)
                                        WHERE uspe_user_id = " . $this->_uid);
		$con  =  $db_sl->result_array();

		if (!empty($con)) {
			$list =  '0';
			foreach ($con as $r) {
				$list .= ',' . $r['con_module_id'];
			}
			$sql = "SELECT * FROM sys_modules WHERE status = 1 AND id IN($list)";
			$db = $this->_CI->db->query($sql);
			$module   =  $db->result('array');
		}

		return $module;
	}

	function get_persons_permisson($step_id) {
		$data = array();
		if (intval($step_id) > 0) {
			$rel = $this->_CI->db->query('SELECT hr_id FROM iso_step_hr WHERE step_id ='. $step_id);
			$numrow = $rel->num_rows();
			if ($numrow > 0) {
				foreach ($rel->result('array') as $item) {
					$data[] = $item['hr_id'];
				}
			}
			$rel->free_result();
		}
		return $data;
	}

	function calendar_exist($person, $step, $read) {
		$qry = "SELECT t1.id FROM calendar t1 WHERE t1.person_id = $person AND t1.step_id = $step AND t1.read = $read";
		$db = $this->_CI->db->query($qry);
		$numRow = $db->num_rows();
		if (intval($numRow) > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function get_important_work($uid) {
		$sql = "SELECT * FROM popup_now t1 WHERE t1.uid = $uid AND t1.show = 0";
		$db = $this->_CI->db->query($sql);
		$numRow = $db->num_rows();
		$data['allTask']['important'] = array();
		if ($numRow > 0) {
			foreach ($db->result('array') as $row) {
				$data['allTask']['important'][] = $row;
			}
		}
		return $data;
	}

	function check_task_popup() {
		$uid = $this->_uid;
		if ($uid > 0) {
			$data = array();
			$data = array_merge($this->get_important_work($uid), $data);
			$allWork = $data['allTask']['important'];
			if (!empty($allWork)) {
				foreach ($allWork as $work) {
					$this->_CI->db->where('id', $work['id']);
					$this->_CI->db->update('popup_now', array('show'=>1));
				}
				$this->_CI->load->vars($data);
				$this->_CI->load->view('home/task/modalTask');
			}
		}
	}

	function check_exist_popup($recipients, $workId, $type) {
		$sql = "SELECT id FROM popup_now WHERE uid = $recipients AND step_id = $workId AND type = '".$type."' ORDER BY type ASC";
		$db = $this->_CI->db->query($sql);
		if ($db->num_rows() > 0) return $db->row_array();
		else return false;
	}

	function process_info($projectId) {
		$data = array();
		$arAccess = array();
		$json = $this->_CI->session->userdata('iso_access');
		if ($json) {
			$arAccess = json_decode($json, TRUE);
		}

		if (intval($projectId) > 0) {
			// List phase
			if (isset($arAccess['phase'])) {
				$listPhase = $arAccess['phase'];
				if (!empty($listPhase[$projectId])) {
					$listPhase[$projectId] = super_sort($listPhase[$projectId], 'id', 'ASC');
					if (!empty($listPhase) && isset($listPhase[$projectId])) {
						$temp = array();
						foreach ($listPhase[$projectId] as $phase) {
							$temp = array_values($listPhase[$projectId]);
						}
						$data['listPhase'] = $temp;
					}
				}
			}
			// List step
			if (isset($arAccess['step'])) {
				$listStep = $arAccess['step'];
				if (!empty($data['listPhase'])) {
					foreach ($data['listPhase'] as $phase) {
						if (isset($listStep[$phase['id']])) {
							$listStep[$phase['id']] = super_sort($listStep[$phase['id']], 'id', 'ASC');
							$data['listStep'] = $listStep;
						}
					}
				}
			}
		}

		return $data;
	}

	function get_document($type, $id) {
		if (trim($type) != '' && intval($id) > 0) {
			$data = array();
			$qry = 'SELECT * FROM iso_document WHERE type = "'. $type .'" AND type_id = '. $id;
			$db = $this->_CI->db->query($qry);
			$numRow = $db->num_rows();
			if (intval($numRow) > 0) {
				foreach ($db->result('array') as $row) {
					$data[] = $row;
				}
			}
			return $data;
		}
		return false;
	}

	function get_project_detail($projectId) {
		if (intval($projectId) > 0) {
			$data = array();
			$db = $this->_CI->db->query("SELECT t1.* FROM iso_phase t1 WHERE t1.project_id = $projectId");
			$num = $db->num_rows();
			if (intval($num) > 0) {
				foreach ($db->result('array') as $row) {
					$data['proPhase'][] = $row;
					$arPhaseId[] = $row['id'];
				}
				$db->free_result();
				unset($db);
				$db = $this->_CI->db->query("SELECT t1.* FROM iso_step t1 WHERE t1.project_id = $projectId");
				$num = $db->num_rows();
				if (intval($num) > 0) {
					foreach ($db->result('array') as $rec) {
						$data['proStep'][$rec['phase_id']][] = $rec;
					}
					$db->free_result();
				}
			}
			return $data;
		} else {
			return false;
		}
	}

	function get_process_detail($process_id) {
		if (intval($process_id) > 0) {
			$data = array();
			$db = $this->_CI->db->query("SELECT t1.* FROM iso_process_phase t1 WHERE t1.process_id = $process_id AND t1.status = 1");
			$num = $db->num_rows();
			if (intval($num) > 0) {
				foreach ($db->result('array') as $row) {
					$data['listPhase'][] = $row;
					$arPhaseId[] = $row['id'];
				}
				$db->free_result();
				unset($db);
				$db = $this->_CI->db->query("SELECT t1.* FROM iso_process_step t1 WHERE t1.process_id = $process_id AND t1.status = 1");
				$num = $db->num_rows();
				if (intval($num) > 0) {
					foreach ($db->result('array') as $rec) {
						$data['listStep'][$rec['phase_id']][] = $rec;
					}
					$db->free_result();
				}
			}
			return $data;
		} else {
			return false;
		}
	}

	// Get all project,phase,step of user invoking
	function get_invoke_of_user($uid) {
		$data = array();
		$temp = array();
		$temp = $this->_CI->session->userdata('iso_access');
		if (!$temp) {

			// Step
			$arPhaseId = array();
			$qry = "SELECT DISTINCT t2.id,t1.function,t2.name,t2.order,t2.phase_id AS pi,t2.time_complete,t2.times_delay,t2.rate_important,t2.progress,t2.project_id,t2.time_start
					FROM iso_step_hr t1 
					INNER JOIN iso_step t2 
					WHERE t1.hr_id = $uid AND t1.step_id = t2.id
					ORDER BY t2.id";

			$db = $this->_CI->db->query($qry);
			if ($db->num_rows() > 0) {
				foreach ($db->result('array') as $row) {
					$data['step'][$row['pi']][] = $row;
					$arPhaseId[] = $row['pi'];
					$arStepId[] = $row['id'];
				}
			}
			unset($db);

			// Phase
			$arProjectId = array();
			if (!empty($arPhaseId)) {
				$qry = 'SELECT DISTINCT t1.id,t1.project_id,t1.name,t1.order,t1.per_lead,t1.per_mornitor,t1.time_start,t1.time_complete
						FROM iso_phase t1 
						WHERE id IN ('. implode(',', $arPhaseId) .')
						ORDER BY t1.id';

				$db = $this->_CI->db->query($qry);
				if ($db->num_rows() > 0) {
					foreach ($db->result('array') as $row) {
						$data['phase'][$row['project_id']][] = $row;
						$arProjectId[] = $row['project_id'];
						$arPhaseId[] = $row['id'];
					}
				}
				unset($db);
			}

			// Lead or Mornitor Phase
			$arPhaseLM = array();
			$qry = "SELECT t1.id,t1.project_id,t1.name,t1.order,t1.per_lead,t1.per_mornitor,t1.time_start,t1.time_complete
					FROM iso_phase t1 
					WHERE per_create = $uid OR per_lead = $uid OR per_mornitor = $uid
					ORDER BY t1.id";

			$dbPhase = $this->_CI->db->query($qry);
			if ($dbPhase->num_rows() > 0) {
				foreach ($dbPhase->result('array') as $row) {
					$arPhaseLM[] = $row['id'];
					$arProjectId[] = $row['project_id'];
					if (!empty($arPhaseId)) {
						if (!in_array($row['id'], $arPhaseId)) {
							$arPhaseId[] = $row['id'];
							$data['phase'][$row['project_id']][] = $row;
						}
					} else {
						$arPhaseId[] = $row['id'];
						$data['phase'][$row['project_id']][] = $row;
					}
				}
			}
			$dbPhase->free_result();
			if (!empty($arPhaseLM)) {
				if (!empty($arStepId)) {
					$qry = "SELECT t1.id,t1.name,t1.order,t1.phase_id,t1.time_complete,t1.times_delay,t1.rate_important,t1.progress,t1.project_id,t1.time_start
							FROM iso_step t1
							WHERE phase_id IN(". implode(',', $arPhaseLM) .") AND id NOT IN(". implode(',', $arStepId) .")
							ORDER BY t1.id";
				} else {
					$qry = "SELECT t1.id,t1.name,t1.order,t1.phase_id,t1.time_complete,t1.times_delay,t1.rate_important,t1.progress,t1.project_id,t1.time_start
							FROM iso_step t1
							WHERE phase_id IN(". implode(',', $arPhaseLM) .")
							ORDER BY t1.id";
				}
				$db = $this->_CI->db->query($qry);
				if ($db->num_rows() > 0) {
					foreach ($db->result('array') as $row) {
						$row['function'] = 3;
						$arStepId[] = $row['id'];
						$data['step'][$row['phase_id']][] = $row;
					}
				}
			}

			// Project
			if (!empty($arProjectId)) {
				$qry = 'SELECT DISTINCT t1.id,t1.name,t1.order,t1.customer_name,t1.time_start,t1.time_complete,t1.status
						FROM iso_project t1 
						WHERE id IN ('. implode(',', $arProjectId) .') 
						ORDER BY t1.id';

				$db = $this->_CI->db->query($qry);
				if ($db->num_rows() > 0) {
					foreach ($db->result('array') as $row) {
						$data['project'][$row['id']] = $row;
					}
				}
				$db->free_result();
			}

			// Leader or Mornitor project
			$arProjectLM = array();
			$qry = "SELECT t1.id,t1.name,t1.order,t1.customer_name,t1.time_start,t1.time_complete,t1.status
					FROM iso_project t1 
					WHERE per_create = $uid OR per_lead = $uid OR per_mornitor = $uid
					ORDER BY t1.id";

			$dbPro = $this->_CI->db->query($qry);
			if ($dbPro->num_rows() > 0) {
				foreach ($dbPro->result('array') as $row) {
					$arProjectLM[] = $row['id'];
					$data['project'][$row['id']] = $row;
				}
			}
			$dbPro->free_result();

			// Get steps in lead project
			if (!empty($arProjectLM)) {
				if (!empty($arStepId)) {
					$qry = "SELECT t1.id,t1.name,t1.order,t1.phase_id,t1.time_complete,t1.times_delay,t1.rate_important,t1.progress,t1.project_id,t1.time_start
							FROM iso_step t1
							WHERE project_id IN(". implode(',', $arProjectLM) .") AND id NOT IN(". implode(',', $arStepId) .")
							ORDER BY t1.id";
				} else {
					$qry = "SELECT t1.id,t1.name,t1.order,t1.phase_id,t1.time_complete,t1.times_delay,t1.rate_important,t1.progress,t1.project_id,t1.time_start
							FROM iso_step t1
							WHERE project_id IN(". implode(',', $arProjectLM) .")
							ORDER BY t1.id";
				}

				$db = $this->_CI->db->query($qry);
				if ($db->num_rows() > 0) {
					foreach ($db->result('array') as $row) {

						// If in this step user is executive
						$function = 0;
						$qry = 'SELECT function FROM iso_step_hr WHERE step_id = '.$row['id'].' AND hr_id = '.$uid;
						$dbCheck = $this->_CI->db->query($qry);
						if ($dbCheck->num_rows() > 0) {
							$temp = $dbCheck->row_array();
							$function = $temp['function'];
						}
						if ($function != 0) {
							$row['function'] = $function;
						} else {
							$row['function'] = 3;
						}

						$data['step'][$row['phase_id']][] = $row;
					}
				}
				$db->free_result();

				// Get phase in lead project
				if (!empty($arPhaseId)) {
					$qry = "SELECT t1.id,t1.project_id,t1.name,t1.order,t1.per_lead,t1.per_mornitor,t1.per_executive,t1.time_start,t1.time_complete
							FROM iso_phase t1
							WHERE project_id IN(". implode(',', $arProjectLM) .") AND id NOT IN(". implode(',', $arPhaseId) .")
							ORDER BY t1.id";
				} else {
					$qry = "SELECT t1.id,t1.project_id,t1.name,t1.order,t1.per_lead,t1.per_mornitor,t1.per_executive,t1.time_start,t1.time_complete
							FROM iso_phase t1
							WHERE project_id IN(". implode(',', $arProjectLM) .")
							ORDER BY t1.id";
				}
				$db = $this->_CI->db->query($qry);
				if ($db->num_rows() > 0) {
					foreach ($db->result('array') as $row) {
						$data['phase'][$row['project_id']][] = $row;
					}
				}
				$db->free_result();
			}

			// Insert into session
			if (!empty($data)) {
				$json = json_encode($data);
				$this->_CI->session->set_userdata(array('iso_access' => $json));
			}

		} else {
			$invoke = $this->_CI->session->userdata('iso_access');
			$data = json_decode($invoke, TRUE);
		}

		return $data;
	}

	// Function get new work
	function get_new_work($uid) {
		if (intval($uid) > 0) {
			$data = array();
			$sql = '	SELECT t1.id,t1.step_id,t1.number,t1.time_create,t2.name,t2.time_complete,t2.progress,t2.times_delay,t2.rate_important,t2.project_id
						FROM calendar t1 
						LEFT JOIN iso_step t2 ON(t1.step_id = t2.id) 
						WHERE t1.person_id = ' .$uid. ' AND t1.read = 0';

			$db = $this->_CI->db->query($sql);
			if ($db->num_rows() > 0) {
				return $db->result('array');
			}
			return $data;
		} else {
			redirect('home');
		}
	}

	// Fucntion get employee info
	function get_employee_by_id($ids) {
		$data = array();
		if ($ids) {
			if (strpos('F' . $ids, ',')) {
				$id = explode(',', $ids);
			} else {
				$id = intval($ids);
			}
			if (is_array($id)) {
				$db = $this->_CI->db->query('SELECT t1.name,t1.id,t1.fullname FROM perm_user t1 WHERE t1.id IN('. implode(',', $id) .') AND t1.status = 1');
			} else {
				$db = $this->_CI->db->query('SELECT t1.name,t1.id,t1.fullname FROM perm_user t1 WHERE t1.id = '. $id .' AND t1.status = 1');
			}
			if ($db->num_rows() > 0) {
				foreach ($db->result('array') as $row) {
					$data[$row['name']] = $row;
				}
			}
			return $data;
		} else {
			return array('---');
		}
	}

	// Get person in step
	function get_employ_in_step($step_id) {
		$data = array();
		$db = $this->_CI->db->query('SELECT DISTINCT t1.hr_id,t1.function FROM iso_step_hr t1 WHERE t1.step_id = '.$step_id);
		$num = $db->num_rows();
		if (intval($num) > 0) {
			foreach ($db->result('array') as $row) {
				$data[] = $row;
			}
		}
		return $data;
	}

	// Check permisson access of project & phase & step
	function check_access_step($sid) {
		$arAccess = $this->_access;
		if (!empty($arAccess) && isset($this->_access['project'])) {
			foreach ($arAccess['project'] as $p) {
				$po[] = $p['id'];
			}
			if (in_array($projectId, $po)) {
				return TRUE;
			}
		}
		return FALSE;
	}

	function get_detail_project($projectid, $getTrans=false) {
		$arPhase = array();
		$arStep = array();
		$data = array();
		$data['idPerson'] = array(0);
		$data['idPhase'] = array();
		$data['idStep'] = array();

		$sql = '	SELECT id,name,project_id,time_create,time_start,time_complete,per_create,per_lead,t1.order, t1.progress, t1.rate_important
					FROM iso_phase t1 
					WHERE project_id = '. $projectid . ' 
					ORDER BY t1.id ASC';

		$db = $this->_CI->db->query($sql);
		$num = $db->num_rows();
		if (intval($num) > 0) {
			foreach ($db->result('array') as $item) {
				$data['lPhase'][] = $item;
				$arPhase[] = $item['id'];

				// Get id create person
				if ($item['per_create'] > 0) {
					if (!in_array($item['per_create'], $data['idPerson'])) $data['idPerson'][] = $item['per_create'];
				}

				// Get id lead person
				if ($item['per_lead'] != '') {
					$tmpPhaseLead = explode(',', $item['per_lead']);
					foreach ($tmpPhaseLead as $tpl) {
						if (!in_array($tpl, $data['idPerson']) && intval($item['per_lead']) > 0) {
							$data['idPerson'][] = $tpl;
						}
					}
				}
			}

			$data['idPhase'] = $arPhase;
			$sql1 = 'SELECT id,name,phase_id,time_create,time_start,time_complete,progress,t1.order,times_delay, t1.rate_important
						FROM iso_step t1 
						WHERE status = 1 AND phase_id IN('. implode(',', $arPhase) .') 
						ORDER BY t1.id ASC';

			$db1 = $this->_CI->db->query($sql1);
			$num = $db1->num_rows();
			if (intval($num) > 0) {
				$stepindex = 0;
				foreach ($db1->result('array') as $subitem) {
					$stepindex++;
					$arStep[] = $subitem['id'];
					$data['lStep'][$subitem['phase_id']][$stepindex] = $subitem;
					$data['lStep'][$subitem['phase_id']][$stepindex]['per_in'] = array();

					// Get person in
					$db3 = $this->_CI->db->query("SELECT hr_id FROM iso_step_hr WHERE step_id = ".$subitem['id']);
					$num = $db3->num_rows();
					if ($num > 0) {
						foreach ($db3->result('array') as $hritem) {
							$data['lStep'][$subitem['phase_id']][$stepindex]['per_in'][] = $hritem['hr_id'];

							// Get person in step
							if (!in_array($hritem['hr_id'], $data['idPerson'])) {
								$data['idPerson'][] = $hritem['hr_id'];
							}
						}
					}
				}
			}

			$data['idStep'] = $arStep;
			if ($getTrans == true) {
				if (!empty($arStep)) {
					$sql2 = 'SELECT * FROM iso_transaction WHERE step_id IN('. implode(',', $arStep) .') ORDER BY id ASC';
					$db2 = $this->_CI->db->query($sql2);
					$num = $db2->num_rows();
					if (intval($num) > 0) {
						foreach ($db2->result('array') as $ssitem) {
							$data['lTrans'][$ssitem['step_id']][] = $ssitem;
						}
					}
				}
			}
		}

		// Unset record 0
		unset($data['idPerson'][0]);

		return $data;
	}

	function get_detail_project_v2($projectid) {
		$arPhase = array();
		$arStep = array();
		$data = array();
		$db = $this->_CI->db->query('SELECT * FROM iso_phase WHERE project_id = '. $projectid);
		$num = $db->num_rows();
		if (intval($num) > 0) {
			foreach ($db->result('array') as $item) {
				$data['listPhase'][] = $item;
				$arPhase[] = $item['id'];
			}
			$db1 = $this->_CI->db->query('SELECT * FROM iso_step WHERE phase_id IN('. implode(',', $arPhase) .') ');
			$num = $db1->num_rows();
			if (intval($num) > 0) {
				foreach ($db1->result('array') as $subitem) {
					$data['listStep'][$subitem['phase_id']][] = $subitem;
				}
			}
		}
		return $data;
	}

	function get_detail_phase($phaseId) {
		$data = array();
		$arStep = array();
		$db = $this->_CI->db->query('SELECT * FROM iso_step WHERE phase_id = '. $phaseId);
		$num = $db->num_rows();
		if (intval($num) > 0) {
			foreach ($db->result('array') as $item) {
				$data['lStep'][] = $item;
			}
		}
		return $data;
	}

	function get_perm($uid) {
		$perm = 0;
		if (intval($uid) > 0) {
			$db = $this->_CI->db->query('SELECT perm FROM mc_employee WHERE id = '.$uid);
			$temp = $db->row();
			$perm = $temp->perm;
		}
		return $perm;
	}

	/**
	 * PermissionModel::getUserPermission()
	 *
	 * @param mixed $uID
	 * @return
	 */
	function getUserPermission($uID) {
		$db_select  =  $this->_CI->db->query("SELECT uspe_function_id
                                       FROM sys_user_permission
                                       WHERE uspe_user_id = " . intval($uID));
		$result  = $db_select->result_array();
		$data =  array();

		foreach ($result as $k => $row) $data[]   =  $row['uspe_function_id'];
		return $data;
	}
}








