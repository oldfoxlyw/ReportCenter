<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Recharge_top30 extends CI_Controller
{
	private $pageName = 'order/recharge_top30';
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
	
	public function lists($format = 'json')
	{
		$this->load->model('utils/return_format');
		$accountdb = $this->load->database('fundsdb', TRUE);
		
		$serverId = $this->input->post('serverId');
		$date = $this->input->post('date');
		$partnerKey = $this->input->post('partnerKey');
		
		if(!empty($date) && !empty($serverId))
		{
			$startTime = strtotime("{$date} 00:00:00");
			$endTime = strtotime("{$date} 23:59:59");

			if(!empty($partnerKey))
			{
				$partner = "AND `partner_key`='{$partnerKey}'";
			}
			else
			{
				$partner = '';
			}
			
			$sql = "SELECT `account_guid`, `account_nickname`, `server_id`, SUM(`funds_amount`) AS `funds_amount` FROM `funds_checkinout` WHERE `funds_flow_dir`='CHECK_IN' AND `appstore_status`=0 AND `server_id`='{$serverId}' AND `funds_time`>={$startTime} AND `funds_time`<={$endTime} {$partner} GROUP BY `account_guid` ORDER BY `funds_amount` DESC LIMIT 30";
			$result = $accountdb->query($sql)->result();
			
			echo $this->return_format->format($result);
		}
	}
}

?>