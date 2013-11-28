<?php

class Equipment_sales extends CI_Controller
{
	private $pageName = 'order/equipment_sales';
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
		
		if(!empty($serverId) && !empty($startTime) && !empty($endTime))
		{
			$startTime = strtotime("{$startTime} 00:00:00");
			$endTime = strtotime("{$endTime} 23:59:59");
			$sql = "SELECT `item_level`, count(*) as `count`  FROM `log_consume` WHERE `server_id`='{$serverId}' AND `partner_key`='{$this->user->user_fromwhere}' AND `action_name`='buy_equipment' AND `log_time`>={$startTime} AND `log_time`<={$endTime} GROUP BY `item_level`";
			$result = $this->mconsume->query($sql);
			
			var_dump($result);
			exit();

			$data = array();
			$data['axis'] = array();
			$data['data'] = array();
			
			for($i=1; $i<=45; $i++)
			{
				array_push($data['axis'], $i);
				$data['data'][$i] = 0;
			}
			
			if(!empty($result))
			{
				foreach($result as $row)
				{
					$data['data'][intval($row->item_level)] = intval($row->count);
				}
			}
			$data['data'] = array_values($data['data']);
			
			$this->load->model('utils/return_format');
			echo $this->return_format->format($data);
		}
	}
}

?>