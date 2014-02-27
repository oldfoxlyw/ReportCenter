<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Recharge extends CI_Controller
{
	private $pageName = 'order/recharge';
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
		$accountdb = $this->load->database('fundsdb', TRUE);
		
		$serverId = $this->input->post('serverId');
		$partnerKey = $this->input->post('partnerKey');
		$startTime = $this->input->post('startTime');
		$endTime = $this->input->post('endTime');
		
		if(!empty($startTime))
		{
			$data = array();
			$data['axis'] = array();
			$data['result'] = array();
			
			$startTime = strtotime("{$startTime} 00:00:00");
			$endTime = strtotime("{$endTime} 23:59:59");
			
			for($i=$startTime; $i<=$endTime; $i+=86400)
			{
				$current = date('Y-m-d', $i);
				array_push($data['axis'], $current);
			}
			
			if(!empty($partnerKey))
			{
				$partner = "AND `partner_key`='{$partnerKey}'";
			}
			
			if(!empty($serverId))
			{
				$sql = "SELECT FROM_UNIXTIME(`funds_time`, '%Y-%m-%d') as `date`, SUM(`funds_amount`) as `amount` FROM `funds_checkinout` WHERE `server_id`='{$serverId}' AND `funds_flow_dir`='CHECK_IN' AND `funds_time`>={$startTime} AND `funds_time`<={$endTime} {$partner} AND `appstore_status`=0 GROUP BY `date`";
			}
			else
			{
				$sql = "SELECT FROM_UNIXTIME(`funds_time`, '%Y-%m-%d') as `date`, SUM(`funds_amount`) as `amount` FROM `funds_checkinout` WHERE `funds_flow_dir`='CHECK_IN' AND `funds_time`>={$startTime} AND `funds_time`<={$endTime} {$partner} AND `appstore_status`=0 GROUP BY `date`";
			}
			$result = $accountdb->query($sql)->result();
			
			foreach($result as $row)
			{
				$data['result'][$row->date] = $row;
			}
			
			echo $this->return_format->format($data);
		}
	}
}

?>