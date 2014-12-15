<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Recharge_flow extends CI_Controller
{
	private $pageName = 'order/recharge_flow';
	private $user = null;

	public function __construct()
	{
		parent::__construct ();
		$this->load->model('utils/check_user', 'check');
		$this->user = $this->check->validate();
		$this->check->permission($this->pageName);
	}
	
	public function index()
	{
		$this->load->model('mserver');
		$this->load->model('mpartner');
		
		$serverResult = $this->mserver->read();
		$partnerResult = $this->mpartner->read();
		$data = array(
			'admin'			=>	$this->user,
			'page_name'		=>	$this->pageName,
			'server_result'	=>	$serverResult,
			'current_time'	=>	time(),
			'partner_result'=>	$partnerResult
		);
		$this->render->render($this->pageName, $data);
	}
	
	public function lists($provider = 'highchart')
	{
		$this->load->model('utils/return_format');
		$fundsdb = $this->load->database('fundsdb', TRUE);
		
		$serverId = $this->input->post('serverId');
		$startTime = $this->input->post('startTime');
		$endTime = $this->input->post('endTime');
		$nickname = $this->input->post('nickname');
		$limit = $this->input->post('limit');
		
		if(!empty($startTime) && !empty($endTime) && !empty($serverId))
		{
			$startTime = strtotime("{$startTime} 00:00:00");
			$endTime = strtotime("{$endTime} 23:59:59");
			if($limit > 0)
			{
				$l = "limit {$limit}";
			}

			if(!empty($nickname))
			{
				$nickname = "AND `account_nickname`='{$nickname}'";
			}
			
			$sql = "SELECT `account_guid`, `account_nickname`, `account_level`, `agent1_account_db`.`web_account`.`account_regtime` AS `account_regtime`,  `funds_amount`, `funds_time_local` FROM `funds_checkinout` INNER JOIN `agent1_account_db`.`web_account` ON `funds_checkinout`.`account_guid`=`agent1_account_db`.`web_account`.`GUID` WHERE `funds_flow_dir`='CHECK_IN' {$nickname} AND `appstore_status`=0 AND `server_id`='{$serverId}' AND `funds_time`>={$startTime} AND `funds_time`<={$endTime} ORDER BY `funds_id` DESC {$l}";
			$result = $fundsdb->query($sql)->result();
			
			echo $this->return_format->format($result);
		}
	}

	public function init()
	{
		$accountdb = $this->load->database('accountdb', TRUE);
		$fundsdb = $this->load->database('fundsdb', TRUE);
		$sql = "select `account_guid` from `funds_checkinout` WHERE `funds_flow_dir`='CHECK_IN' group by `account_guid`";
		$result = $fundsdb->query($sql)->result();

		foreach($result as $row)
		{
			$guid = $row->account_guid;
			$sql = "select `account_level` from `web_account` where `GUID`={$guid}";
			$account = $accountdb->query($sql)->row();
			$level = $account->account_level;
			$sql = "update `funds_checkinout` set `account_level`={$level} where `account_guid`={$guid} AND `funds_flow_dir`='CHECK_IN'";
			$fundsdb->query($sql);
		}
	}
}

?>