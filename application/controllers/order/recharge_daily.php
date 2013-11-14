<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Recharge_daily extends CI_Controller
{
	private $pageName = 'order/recharge_daily';
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
		
		$serverResult = $this->mserver->read();
		$data = array(
			'admin'			=>	$this->user,
			'page_name'		=>	$this->pageName,
			'server_result'	=>	$serverResult,
			'current_time'	=>	time()
		);
		$this->render->render($this->pageName, $data);
	}
	
	public function lists($provider = 'highchart')
	{
		$this->load->model('utils/return_format');
		$accountdb = $this->load->database('fundsdb', TRUE);
		
		$serverId = $this->input->post('serverId');
		$startTime = $this->input->post('startTime');
		
		if(!empty($serverId) && !empty($startTime))
		{
			$startTime = strtotime("{$startTime} 00:00:00");
			$endTime = $startTime + 86399;
			
			$sql = "SELECT FROM_UNIXTIME(`funds_time`, '%k') as `hour`, SUM(`funds_amount`) as `amount` FROM `funds_checkinout` WHERE `funds_flow_dir`='CHECK_IN' AND `funds_time`>={$startTime} AND `funds_time`<={$endTime} GROUP BY `hour`";
			$result = $accountdb->query($sql)->result();
			
			echo $this->return_format->format($result);
		}
	}
}

?>