<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Experience_log extends CI_Controller
{
	private $pageName = 'logs/experience_log';
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
	
	public function lists()
	{
		$this->load->model('utils/return_format');
		$fundsdb = $this->load->database('fundsdb', TRUE);
		
		$serverId = $this->input->post('serverId');
		$startTime = $this->input->post('startTime');
		$endTime = $this->input->post('endTime');
		$nickname = $this->input->post('nickname');
		$accountId = $this->input->post('accountId');
		$roleId = $this->input->post('roleId');
		$limit = $this->input->post('limit');
		
		if(!empty($serverId))
		{
			$cache_db = $this->load->database('logcachedb', TRUE);
			if(!empty($startTime))
			{
				$startTime = strtotime("{$startTime} 00:00:00");
				$cache_db->where('time >=', $startTime);
			}
			if(!empty($startTime))
			{
				$endTime = strtotime("{$endTime} 23:59:59");
				$cache_db->where('time <=', $endTime);
			}
			if(!empty($roleId))
			{
				$cache_db->where('role_id', $roleId);
			}
			else
			{
				if(!empty($accountId))
				{
					$cache_db->where('guid', $accountId);
				}
				else
				{
					if(!empty($nickname))
					{
						$this->load->model('maccount');
						$result = $this->maccount->read(array(
							'account_nickname'	=>	$nickname
						));
						if(!empty($result))
						{
							$row = $result[0];
							$guid = $row->GUID;
							$cache_db->where('guid', $guid);
						}
						else
						{
							echo $this->return_format->format(array(
								'code'		=>	-1,
								'data'		=>	null
							));
							exit();
						}
					}
				}
			}
			if(!empty($limit))
			{
				$cache_db->limit(intval($limit));
			}

			$result = $cache_db->get('equipment_logs')->result();
			
			echo $this->return_format->format(array(
				'code'		=>	0,
				'data'		=>	$result
			));
		}
	}
}

?>