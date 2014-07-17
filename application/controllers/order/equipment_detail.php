<?php
class Equipment_detail extends CI_Controller
{
	private $pageName = 'order/equipment_detail';
	private $user = null;
	
	public function __construct()
	{
		parent::__construct ();
		$this->load->model ( 'utils/check_user', 'check' );
		$this->user = $this->check->validate ();
		$this->check->permission ( $this->pageName );
	}
	
	public function index()
	{
		$this->load->model ( 'mserver' );
		
		$serverResult = $this->mserver->read ();
		$data = array (
			'admin' => $this->user,
			'page_name' => $this->pageName,
			'server_result' => $serverResult,
			'current_time' => time()
		);
		$this->render->render ( $this->pageName, $data );
	}

	public function lists($provider = 'highchart')
	{
		$this->load->model('mconsume');
		
		$serverId = $this->input->post('serverId');
		$startTime = $this->input->post('startTime');
		$endTime = $this->input->post('endTime');
		$equipmentName = $this->input->post('equipmentName');
		
		if(!empty($serverId) && !empty($equipmentName) && !empty($startTime) && !empty($endTime))
		{
			$startTime = strtotime("{$startTime} 00:00:00");
			$endTime = strtotime("{$endTime} 23:59:59");
			// $sql = "SELECT FROM_UNIXTIME(`log_time`, '%Y-%m-%d') as `date`, count(*) as `count`  FROM `log_consume` WHERE `server_id`='{$serverId}' AND `partner_key`='{$this->user->user_fromwhere}' AND `action_name`='buy_equipment' AND `item_name`='{$equipmentName}' AND `log_time`>={$startTime} AND `log_time`<={$endTime} GROUP BY `date`";
			$sql = "SELECT FROM_UNIXTIME(`log_time`, '%Y-%m-%d') as `date`, count(*) as `count`  FROM `log_consume` WHERE `server_id`='{$serverId}' AND `action_name`='buy_equipment' AND `item_name`='{$equipmentName}' AND `log_time`>={$startTime} AND `log_time`<={$endTime} GROUP BY `date`";
			$result = $this->mconsume->query($sql);

			$data = array();
			$data['axis'] = array();
			$data['data'] = array();
			
			for($i=$startTime; $i<=$endTime; $i+=86400)
			{
				array_push($data['axis'], date('Y-m-d', $i));
				$data['data'][date('Y-m-d', $i)] = 0;
			}
			if(!empty($result))
			{
				foreach($result as $row)
				{
					$data['data'][$row->date] = intval($row->count);
				}
			}
			$data['data'] = array_values($data['data']);
			
			$this->load->model('utils/return_format');
			echo $this->return_format->format($data);
		}
	}
}

?>