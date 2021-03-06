<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller
{
	private $pageName = 'index';
	private $user = null;
	
	public function __construct()
	{
		parent::__construct ();
		$this->load->model('utils/check_user', 'check');
		$this->user = $this->check->validate();
	}
	
	public function index()
	{
		$this->load->model('mserver');
		$serverResult = $this->mserver->read(array(
				'server_debug'		=>	0,
				'server_status !='	=>	9
		));
		
		$data = array(
			'admin'				=>	$this->user,
			'page_name'			=>	$this->pageName,
			'server'			=>	$serverResult
		);
		$this->render->render($this->pageName, $data);
	}
	
	public function charts($provider = 'highchart')
	{
		$this->load->model('moverview');
		$this->load->model('utils/return_format');
		$logcachedb = $this->load->database('logcachedb', TRUE);
		
		$serverId = $this->input->post('server_id');
// 		$partnerKey = $this->input->post('partnerKey');
		
		if(!empty($serverId))
		{
			$currentTime = strtotime(date('Y-m-d') . ' 00:00:00');
			$lastTime = $currentTime - 86400;
			$lastDate = date('Y-m-d', $lastTime) . ' 23:59:59';
			$sevenDaysAgoTime = $lastTime - 6 * 86400;
			$sevenDaysAgoDate = date('Y-m-d', $sevenDaysAgoTime) . ' 00:00:00';
			
			if(!empty($partnerKey))
			{
				$partner = "AND `partner_key`='{$partnerKey}'";
			}
			
			$result = array();
			$result['axis'] = array();
			for($i = $sevenDaysAgoTime; $i <= $lastTime; $i += 86400)
			{
				array_push($result['axis'], date('Y-m-d', $i));
			}
			$sql = "SELECT `log_date`, SUM(`dau`) as `dau`, SUM(`level_account`) as `level_account`, SUM(`login_account`) as `login_account` FROM `log_daily_statistics` WHERE `log_date`>='{$sevenDaysAgoDate}' AND `log_date`<='{$lastDate}' AND `server_id`='{$serverId}' {$partner} GROUP BY `log_date` ORDER BY `log_date` ASC";
			$overviewResult = $logcachedb->query($sql)->result();
			
			$registerResult = array();
			$validResult = array();
			$loginResult = array();
			$nextRetentionResult = array();
			foreach($overviewResult as $row)
			{
				array_push($registerResult, $row->dau);
				array_push($validResult, $row->level_account);
				array_push($loginResult, $row->login_account);
			}

			$sql = "SELECT * FROM `log_retention1` WHERE `log_date`>='{$sevenDaysAgoDate}' AND `log_date`<='{$lastDate}' AND `server_id`='{$serverId}' AND `partner_key`='' ORDER BY `log_date` ASC";
			$retention = $logcachedb->query($sql)->result();
			foreach($retention as $row)
			{
				array_push($nextRetentionResult, $row->next_retention);
			}
			
			$result['dau_result'] = $registerResult;
			$result['valid_result'] = $validResult;
			$result['login_result'] = $loginResult;
			$result['next_retention_result'] = $nextRetentionResult;

			header('Content-type:text/json');
			echo $this->return_format->format($result);
		}
	}
	
	public function lists($provider = 'overview')
	{
		$this->load->model('utils/return_format');
		$logcachedb = $this->load->database('logcachedb', TRUE);
		
		$serverId = $this->input->get('server_id');
// 		$partnerKey = $this->input->post('partnerKey');
		$sEcho = $this->input->get_post('sEcho');
		$offset = $this->input->get_post('iDisplayStart');
		$limit = $this->input->get_post('iDisplayLength');
		$keyword = $this->input->get_post('sSearch');
		
		$currentTime = time();
		$lastTime = $currentTime - 86400;
		$lastDate = date('Y-m-d', $lastTime) . ' 23:59:59';
		$sevenDaysAgoTime = $lastTime - 6 * 86400;
		$sevenDaysAgoDate = date('Y-m-d', $sevenDaysAgoTime) . ' 00:00:00';
		
		if(!empty($partnerKey))
		{
			$partner = "AND `partner_key`='{$partnerKey}'";
		}

		$sql = "SELECT COUNT(*) as `numrows` FROM `log_daily_statistics` WHERE `log_date`>='{$sevenDaysAgoDate}' AND `log_date`<='{$lastDate}' AND `server_id`='{$serverId}' {$partner}";
		$count = $logcachedb->query($sql)->row();
		$count = $count->numrows;
		
		$sql = "SELECT `log_date`, `server_id`, SUM(`reg_account`) AS `reg_account`, SUM(`reg_new_account`) AS `reg_new_account`";
		$sql .= " , SUM(`valid_account`) AS `valid_account` , SUM(`valid_new_account`) AS `valid_new_account`";
		$sql .= " , SUM(`modify_account`) AS `modify_account` , SUM(`modify_new_account`) AS `modify_new_account`";
		$sql .= " , SUM(`login_account`) AS `login_account` , SUM(`login_account_valid`) AS `login_account_valid`";
		$sql .= " , SUM(`dau`) AS `dau` , SUM(`flowover_account`) AS `flowover_account`";
		$sql .= " , SUM(`reflow_account`) AS `reflow_account` , SUM(`orders_current_sum`) AS `orders_current_sum`";
		$sql .= " , SUM(`orders_sum`) AS `orders_sum`";
		$sql .= " , SUM(`recharge_account`) AS `recharge_account`, SUM(`order_count`) AS `order_count` , AVG(`at`) AS `at`";
		$sql .= " FROM `log_daily_statistics` WHERE `log_date`>='{$sevenDaysAgoDate}' AND `log_date`<='{$lastDate}' AND `server_id`='{$serverId}' {$partner} GROUP BY `log_date` ORDER BY `log_date` DESC";
		$result = $logcachedb->query($sql)->result();
		
		$sql = "SELECT * FROM `log_retention1` WHERE `log_date`>='{$sevenDaysAgoDate}' AND `log_date`<='{$lastDate}' AND `server_id`='{$serverId}' AND `partner_key`='' ORDER BY `log_date` DESC";
		$retention = $logcachedb->query($sql)->result();

		$retentionResult = array();
		foreach($retention as $row)
		{
			$retentionResult[$row->log_date . '_' . $row->server_id . '_' . $row->partner_key] = $row;
		}
		
		for($i=0; $i<count($result); $i++)
		{
			$result[$i]->arpu = floatval(number_format($result[$i]->recharge_account / $result[$i]->dau, 4)) * 100;
			$re = $retentionResult[$result[$i]->log_date . '_' . $result[$i]->server_id . '_' . $result[$i]->partner_key];
			if(!empty($re))
			{
				$result[$i]->level_account = $re->level_account;
				$result[$i]->next_current_login = $re->next_current_login;
				$result[$i]->third_current_login = $re->third_current_login;
				$result[$i]->third_current_login_range = $re->third_current_login_range;
				$result[$i]->seven_current_login = $re->seven_current_login;
				$result[$i]->seven_current_login_range = $re->seven_current_login_range;
				$result[$i]->seven_current_login_huge = $re->seven_current_login_huge;
				$result[$i]->next_retention = $re->next_retention;
				$result[$i]->third_retention = $re->third_retention;
				$result[$i]->third_retention_range = $re->third_retention_range;
				$result[$i]->seven_retention = $re->seven_retention;
				$result[$i]->seven_retention_range = $re->seven_retention_range;
				$result[$i]->seven_retention_huge = $re->seven_retention_huge;
			}
			else
			{
				$result[$i]->level_account = '-';
				$result[$i]->next_current_login = '-';
				$result[$i]->third_current_login = '-';
				$result[$i]->third_current_login_range = '-';
				$result[$i]->seven_current_login = '-';
				$result[$i]->seven_current_login_range = '-';
				$result[$i]->seven_current_login_huge = '-';
				$result[$i]->next_retention = '-';
				$result[$i]->third_retention = '-';
				$result[$i]->third_retention_range = '-';
				$result[$i]->seven_retention = '-';
				$result[$i]->seven_retention_range = '-';
				$result[$i]->seven_retention_huge = '-';
			}
		}

		$data = array(
				'sEcho'						=>	$sEcho,
				'iTotalRecords'				=>	$count,
				'iTotalDisplayRecords'		=>	$count,
				'aaData'					=>	$result
		);
		
		echo $this->return_format->format($data);
	}
}

?>