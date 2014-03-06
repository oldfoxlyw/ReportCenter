<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Current_online extends CI_Controller
{
	private $pageName = 'account/current_online';
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
		for($i=0; $i<count($serverResult); $i++)
		{
			$serverResult[$i]->server_ip = json_decode($serverResult[$i]->server_ip);
			$serverResult[$i]->server_ip = $serverResult[$i]->server_ip[0];
			if(intval($serverResult[$i]->account_server_id) >= 103)
			{
				$serverResult[$i]->server_ip = $serverResult[$i]->server_ip->ip . ':8090';
			}
			else
			{
				$serverResult[$i]->server_ip = $serverResult[$i]->server_ip->ip . ':' . $serverResult[$i]->server_ip->port;
			}
		}
		
		
		
		$data = array(
			'admin'					=>	$this->user,
			'page_name'			=>	$this->pageName,
			'server_result'		=>	$serverResult
		);
		$this->render->render($this->pageName, $data);
	}
	
	public function lists()
	{
		$this->load->model('utils/connector');
		
		$ip = $this->input->post('serverIp', FALSE);

		if(!empty($ip))
		{
			echo $this->connector->post($ip . '/get_online_count', null, FALSE);
		}
	}
}

?>