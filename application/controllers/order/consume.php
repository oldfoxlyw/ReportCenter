<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Consume extends CI_Controller
{
	private $pageName = 'order/consume';
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
		$this->load->model('mconsume');
		$this->load->model('mserver');
		
		$serverResult = $this->mserver->read();
		$data = array(
			'admin'				=>	$this->user,
			'page_name'		=>	$this->pageName,
			'server_result'	=>	$serverResult,
			'current_time' => time()
		);
		$this->render->render($this->pageName, $data);
	}
	
	public function lists($provider = 'highchart')
	{
		$this->load->helper('language');
		$this->lang->load('consume');
		$this->load->model('mconsume');
		$this->load->model('utils/return_format');

		$serverId = $this->input->post ( 'serverId' );
		$playerId = $this->input->post ( 'playerId' );
		$startTime = $this->input->post('startTime');
		$endTime = $this->input->post('endTime');
		
		$startTime = strtotime("{$startTime} 00:00:00");
		$endTime = strtotime("{$endTime} 23:59:59");
		
		if(empty($playerId))
		{
			$sql = "SELECT `action_name`, SUM(`spend_special_gold`) as `spend_special_gold` FROM `log_consume` WHERE `server_id`='{$serverId}' AND `log_time`>={$startTime} AND `log_time`<={$endTime} GROUP BY `action_name`";
		}
		else
		{
			$sql = "SELECT `action_name`, SUM(`spend_special_gold`) as `spend_special_gold` FROM `log_consume` WHERE `server_id`='{$serverId}' AND `player_id`={$playerId} AND `log_time`>={$startTime} AND `log_time`<={$endTime} GROUP BY `action_name`";
		}
		$result = $this->mconsume->query($sql);
		if($result !== FALSE)
		{
			$axis = array();
			for($i = 0; $i<count($result); $i++)
			{
				$str = lang('consume_' . $result[$i]->action_name);
				$result[$i]->action_name = $str ? $str : $result[$i]->action_name;
				array_push($axis, $result[$i]->action_name );
			}
			
			$parameter = array(
				'axis'		=>	$axis,
				'data'		=>	$result
			);
		}
		else
		{
			$parameter = array();
		}
		
		echo $this->return_format->format($parameter);
	}
}

?>