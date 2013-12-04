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

			$levelData = array();
			$levelData['axis'] = array();
			$levelData['data'] = array();
			
			for($i=1; $i<=45; $i++)
			{
				array_push($levelData['axis'], $i);
				$levelData['data'][$i] = 0;
			}
			
			if(!empty($result))
			{
				foreach($result as $row)
				{
					if($row->item_level != '0')
					{
						$levelData['data'][intval($row->item_level)] = intval($row->count);
					}
				}
			}
			$levelData['data'] = array_values($levelData['data']);


			$sql = "SELECT `item_value`, count(*) as `count`  FROM `log_consume` WHERE `server_id`='{$serverId}' AND `partner_key`='{$this->user->user_fromwhere}' AND `action_name`='buy_equipment' AND `log_time`>={$startTime} AND `log_time`<={$endTime} GROUP BY `item_value`";
			$result = $this->mconsume->query($sql);
			
			$valueData = array();
			$valueData['axis'] = array();
			$valueData['data'] = array();
				
			for($i=1; $i<=45; $i++)
			{
				array_push($valueData['axis'], $i);
				$valueData['data'][$i] = 0;
			}
				
			if(!empty($result))
			{
				foreach($result as $row)
				{
					if($row->item_level != '0')
					{
						$valueData['data'][intval($row->item_level)] = intval($row->count);
					}
				}
			}
			$valueData['data'] = array_values($valueData['data']);
			
			$data = array(
					'level_data'	=>	$levelData,
					'value_data'	=>	$valueData
			);
			
			$this->load->model('utils/return_format');
			echo $this->return_format->format($data);
		}
	}
}

?>