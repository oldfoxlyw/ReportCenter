<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Consume_detail extends CI_Controller
{
	private $pageName = 'order/consume_detail';
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
		$nickname = $this->input->post ( 'nickname' );
		$startTime = $this->input->post('startTime');
		$endTime = $this->input->post('endTime');
		
		$startTime = strtotime("{$startTime} 00:00:00");
		$endTime = strtotime("{$endTime} 23:59:59");

		if(!empty($nickname) && !empty($serverId))
		{
			$this->load->model('maccount');
			$result = $this->maccount->read(array(
				'account_nickname'	=>	$nickname,
				'server_id'			=>	$serverId
			));
			if(!empty($result))
			{
				$result = $result[0];
				$accountId = $result->GUID;

				$sql = "SELECT * FROM `log_consume` WHERE `player_id`='{$accountId}' AND `log_time`>={$startTime} AND `log_time`<={$endTime}";
				$result = $this->mconsume->query($sql);
				
				if($result !== FALSE)
				{
					for($i = 0; $i<count($result); $i++)
					{
						$str = lang('consume_' . $result[$i]->action_name);
						$result[$i]->action_name = $str ? $str : $result[$i]->action_name;
						$result[$i]->log_time = date('Y-m-d H:i:s', $result[$i]->log_time);
					}
					
					$parameter = array(
						'data'		=>	$result
					);
				}
				else
				{
					$parameter = array();
				}
				
				echo $this->return_format->format($parameter);
			}
			else
			{
				$parameter = array(
					'success'	=>	0,
					'message'	=>	'ERROR_ACCOUNT_NOT_EXIST'
				);
				echo $this->return_format->format($parameter);
			}
		}
		else
		{
			$parameter = array(
				'success'	=>	0,
				'message'	=>	'ERROR_NO_PARAM'
			);
			echo $this->return_format->format($parameter);
		}
	}
}

?>