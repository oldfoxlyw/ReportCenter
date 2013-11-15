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
				'server_status !='	=>	9,
				'partner'			=>	$this->user->user_fromwhere
		));
		$data = array(
			'admin'			=>	$this->user,
			'page_name'		=>	$this->pageName,
			'server'		=>	$serverResult
		);
		$this->render->render($this->pageName, $data);
	}
	
	public function charts($provider = 'highchart')
	{
		$this->load->model('moverview');
		$this->load->model('utils/return_format');
		$logcachedb = $this->load->database('logcachedb', TRUE);
		
		$serverId = $this->input->post('server_id');
		
		if(!empty($serverId))
		{
			$currentTime = time();
			$lastTime = $currentTime - 86400;
			$lastDate = date('Y-m-d', $lastTime) . ' 23:59:59';
			$sevenDaysAgoTime = $lastTime - 7 * 86400;
			$sevenDaysAgoDate = date('Y-m-d', $sevenDaysAgoTime) . ' 00:00:00';
			
			$result = array();
			$result['axis'] = array();
			for($i = $sevenDaysAgoTime + 86400; $i <= $lastTime; $i += 86400)
			{
				array_push($result['axis'], date('Y-m-d', $i));
			}
			$sql = "SELECT `log_date`, `reg_new_account`, `modify_new_account`, `login_account` FROM `log_daily_statistics` WHERE `log_date`>='{$sevenDaysAgoDate}' AND `log_date`<='{$lastDate}' AND `server_id`='{$serverId}' AND `partner_key`='{$this->user->user_fromwhere}' ORDER BY `log_date` ASC";
			$overviewResult = $logcachedb->query($sql)->result();
			
			$registerResult = array();
			$validResult = array();
			$loginResult = array();
			$nextRetentionResult = array();
			foreach($overviewResult as $row)
			{
				array_push($registerResult, $row->reg_new_account);
				array_push($validResult, $row->modify_new_account);
				array_push($loginResult, $row->login_account);
			}

			$sql = "SELECT * FROM `log_retention` WHERE `log_date`>='{$sevenDaysAgoDate}' AND `log_date`<='{$lastDate}' AND `server_id`='{$serverId}' AND `partner_key`='{$this->user->user_fromwhere}' ORDER BY `log_date` ASC";
			$retention = $logcachedb->query($sql)->result();
			foreach($retention as $row)
			{
				array_push($nextRetentionResult, $row->next_retention);
			}
			
			$result['register_result'] = $registerResult;
			$result['valid_result'] = $validResult;
			$result['login_result'] = $loginResult;
			$result['next_retention_result'] = $nextRetentionResult;

			header('Content-type:text/json');
			echo $this->return_format->format($result);
		}
	}
	
	public function lists($provider = 'highchart')
	{
		$this->load->model('utils/return_format');
		$logcachedb = $this->load->database('logcachedb', TRUE);
		
		$serverId = $this->input->get('server_id');
		$sEcho = $this->input->get_post('sEcho');
		$offset = $this->input->get_post('iDisplayStart');
		$limit = $this->input->get_post('iDisplayLength');
		$keyword = $this->input->get_post('sSearch');
		
		$currentTime = time();
		$lastTime = $currentTime - 86400;
		$lastDate = date('Y-m-d', $lastTime) . ' 23:59:59';
		$sevenDaysAgoTime = $lastTime - 7 * 86400;
		$sevenDaysAgoDate = date('Y-m-d', $sevenDaysAgoTime) . ' 00:00:00';
		
		$sql = "SELECT COUNT(*) as `numrows` FROM `log_daily_statistics` WHERE `log_date`>='{$sevenDaysAgoDate}' AND `log_date`<='{$lastDate}' AND `server_id`='{$serverId}' AND `partner_key`='{$this->user->user_fromwhere}'";
		$count = $logcachedb->query($sql)->row();
		$count = $count->numrows;
		
		$sql = "SELECT * FROM `log_daily_statistics` WHERE `log_date`>='{$sevenDaysAgoDate}' AND `log_date`<='{$lastDate}' AND `server_id`='{$serverId}' AND `partner_key`='{$this->user->user_fromwhere}' ORDER BY `log_date` DESC";
		$result = $logcachedb->query($sql)->result();
		
		$sql = "SELECT * FROM `log_retention` WHERE `log_date`>='{$sevenDaysAgoDate}' AND `log_date`<='{$lastDate}' AND `server_id`='{$serverId}' AND `partner_key`='{$this->user->user_fromwhere}' ORDER BY `log_date` DESC";
		$retention = $logcachedb->query($sql)->result();
		
		$retentionResult = array();
		foreach($retention as $row)
		{
			$retentionResult[$row->log_date . '_' . $row->server_id . '_' . $row->partner_key] = $row;
		}
		
		for($i=0; $i<count($result); $i++)
		{
			$re = $retentionResult[$result[$i]->log_date . '_' . $result[$i]->server_id . '_' . $result[$i]->partner_key];
			if(!empty($re))
			{
				$result[$i]->prev_current_login = $re->prev_current_login;
				$result[$i]->third_current_login = $re->third_current_login;
				$result[$i]->next_retention = $re->next_retention;
				$result[$i]->third_retention = $re->third_retention;
			}
			else
			{
				$result[$i]->prev_current_login = '-';
				$result[$i]->third_current_login = '-';
				$result[$i]->next_retention = '-';
				$result[$i]->third_retention = '-';
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