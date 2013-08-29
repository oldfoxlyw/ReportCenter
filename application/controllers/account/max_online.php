<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Max_online extends CI_Controller
{
	private $pageName = 'account/max_online';
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

	public function lists()
	{
		$this->load->model ( 'monlinecount' );
		
		$serverId = $this->input->post ( 'serverId' );
		$startTime = $this->input->post ( 'startTime' );
		$type = $this->input->post ( 'type' );
		
		if (! empty ( $serverId ) && ! empty ( $startTime ) && ! empty ( $type ))
		{
			if($type == '1')
			{
				$parameter = array(
					'server_id'			=>	$serverId,
					'log_date'			=>	$startTime
				);
				$result = $this->monlinecount->read($parameter);
			}
			elseif ($type == '2')
			{
				$endDate = date('Y-m-d', strtotime("{$startTime} 00:00:00 Sunday"));
				$startDate = date('Y-m-d', strtotime("{$endDate} 00:00:00 - 6 days"));
				
				$parameter = array(
					'server_id'				=>	$serverId,
					'log_date >='		=>	$startDate,
					'log_date <='		=>	$endDate
				);
				$sql = "SELECT `server_id`, `log_date`, MAX(`log_count`) FROM `log_online_count` WHERE `server_id`='{$serverId}' AND `log_date`>='{$startDate}' AND `log_date`<='{$endDate}' GROUP BY `log_date`";
				$result = $this->monlinecount->query($sql);
			}
			elseif ($type == '3')
			{
				
			}
			
			echo json_encode($result);
		}
	}
}

?>