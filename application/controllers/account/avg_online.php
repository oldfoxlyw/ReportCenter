<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Avg_online extends CI_Controller
{
	private $pageName = 'account/avg_online';
	private $user = null;

	public function __construct()
	{
		parent::__construct ();
		$this->load->model ( 'utils/check_user', 'check' );
		$this->user = $this->check->validate ();
	}

	public function index()
	{
		$this->load->model ( 'mserver' );
		$serverResult = $this->mserver->read ();
		
		$data = array (
			'admin' => $this->user,
			'page_name' => $this->pageName,
			'current_time' => time (),
			'server_result' => $serverResult 
		);
		$this->render->render ( $this->pageName, $data );
	}

	public function lists($provider = 'highchart')
	{
		$this->load->model ( 'monlinecount' );
		
		$serverId = $this->input->post ( 'serverId' );
		$startTime = $this->input->post ( 'startTime' );
		$type = $this->input->post ( 'type' );
		
		if (! empty ( $serverId ) && ! empty ( $startTime ) && ! empty ( $type ))
		{
			$data = array();
			$data['axis'] = array();
			$data[$serverId] = array();
			if ($type == '2')
			{
				$endTimestamp = strtotime("{$startTime} 00:00:00 Sunday");
				$endDate = date('Y-m-d', $endTimestamp);
				$startTimestamp = strtotime("{$endDate} 00:00:00 - 6 days");
				$startDate = date('Y-m-d', $startTimestamp);
				
				for($i=$startTimestamp; $i<=$endTimestamp; $i+=86400)
				{
					$current = date('Y-m-d', $i);
					$data[$serverId][$current] = null;
					array_push($data['axis'], $current);
				}
				
				$sql = "SELECT `server_id`, `log_date`, AVG(`log_count`) as `log_count` FROM `log_online_count` WHERE `server_id`='{$serverId}' AND `log_date`>='{$startDate}' AND `log_date`<='{$endDate}' GROUP BY `log_date`";
				$result = $this->monlinecount->query($sql);

				foreach($result as $row)
				{
					$data[$serverId][$row->log_date] = $row;
				}
			}
			elseif ($type == '3')
			{
				$startDate = date('Y-m', strtotime("{$startTime} 00:00:00")) . '-01';
				$startTimestamp = strtotime($startDate);
				$endDate = date('Y-m-d', strtotime($startTime) + 30 * 86400);
				$endTimestamp = strtotime($endDate);

				for($i=$startTimestamp; $i<=$endTimestamp; $i+=86400)
				{
					$current = date('Y-m-d', $i);
					$data[$serverId][$current] = null;
					array_push($data['axis'], $current);
				}

				$sql = "SELECT `server_id`, `log_date`, AVG(`log_count`) as `log_count` FROM `log_online_count` WHERE `server_id`='{$serverId}' AND `log_date`>='{$startDate}' AND `log_date`<='{$endDate}' GROUP BY `log_date`";
				$result = $this->monlinecount->query($sql);

				foreach($result as $row)
				{
					$data[$serverId][$row->log_date] = $row;
				}
			}
			
			echo json_encode($data);
		}
	}
}

?>