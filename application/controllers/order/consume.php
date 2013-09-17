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
			'server_result'	=>	$serverResult
		);
		$this->render->render($this->pageName, $data);
	}
	
	public function lists($provider = 'highchart')
	{
		$this->load->model('mconsume');
		$this->load->model('utils/return_format');

		$serverId = $this->input->post ( 'serverId' );
		$playerId = $this->input->post ( 'playerId' );
		
		if(empty($playerId))
		{
			$sql = "SELECT `action_name`, SUM(`spend_special_gold`) as `spend_special_gold` FROM `log_consume` WHERE `server_id`='{$serverId}' GROUP BY `action_name`";
		}
		else
		{
			$sql = "SELECT `action_name`, SUM(`spend_special_gold`) as `spend_special_gold` FROM `log_consume` WHERE `server_id`='{$serverId}' AND `player_id`={$playerId} GROUP BY `action_name`";
		}
		$result = $this->mconsume->query($sql);
		if($result !== FALSE)
		{
			$axis = array();
			foreach($result as $row)
			{
				array_push($axis, $row->action_name);
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