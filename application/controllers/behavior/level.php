<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Level extends CI_Controller
{
	private $pageName = 'behavior/level';
	private $user = null;

	public function __construct()
	{
		parent::__construct ();
		$this->load->model('utils/check_user', 'check');
		$this->user = $this->check->validate();
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
		
		$serverId = $this->input->post('server_id');
		if(!empty($serverId))
		{
			$sql = "SELECT `account_level`, count(*) as `count` FROM `web_account` WHERE `server_id`='{$serverId}' GROUP BY `account_level`";
		}
		else
		{
			$sql = "SELECT `account_level`, count(*) as `count` FROM `web_account` GROUP BY `account_level`";
		}
		$result = $accountdb->query($sql)->result_array();
		
		$category = array();
		$data = array();
		for($i=0; $i<count($result); $i++)
		{
			$result[$i] = array_values($result[$i]);
			array_push($category, $result[$i][0]);
			array_push($data, $result[$i][1]);
		}
		
		$parameter = array(
			'category'		=>	$category,
			'data'			=>	$data,
			'result'			=>	$result
		); 
		echo $this->return_format->format($parameter);
	}
}

?>