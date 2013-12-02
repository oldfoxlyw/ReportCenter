<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Progress extends CI_Controller
{
	private $pageName = 'behavior/progress';
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
			'page_name'	=>	$this->pageName,
			'server'			=>	$serverResult
		);
		$this->render->render($this->pageName, $data);
	}
	
	public function lists($provider = 'highchart')
	{
		$this->load->model('utils/return_format');
		$accountdb = $this->load->database('accountdb', TRUE);
		
		$this->config->load('mission_config');
		$missionConfig = $this->config->item('mission_config');
		
		$serverId = $this->input->post('server_id');
		if(!empty($serverId))
		{
			$sql = "SELECT `account_mission`, count(*) as `count` FROM `web_account` WHERE `account_mission`<>'' AND `server_id`='{$serverId}' GROUP BY `account_mission`";
		}
		else
		{
			$sql = "SELECT `account_mission`, count(*) as `count` FROM `web_account` WHERE `account_mission`<>'' GROUP BY `account_mission`";
		}
		$result = $accountdb->query($sql)->result_array();
		
		$category = array();
		$data = array();
		for($i=0; $i<count($result); $i++)
		{
			$result[$i] = array_values($result[$i]);
			$result[$i][2] = $missionConfig[$result[$i][0]]['level'];
			
			$missionName = $missionConfig[$result[$i][0]]['name'];
			$missionName = !empty($missionName) ? $missionName . '[' . $result[$i][2] . '级]' : $result[$i][0];
			$result[$i][0] = $missionName;
			
			array_push($category, $missionName);
			array_push($data, $result[$i][1]);
		}
		
		$parameter = array(
			'category'		=>	$category,
			'data'			=>	$data,
			'result'		=>	$result
		); 
		
		echo $this->return_format->format($parameter);
	}
}

?>