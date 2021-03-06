<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Job extends CI_Controller
{
	private $pageName = 'behavior/job';
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
		$this->load->helper('language');
		$this->lang->load('job');
		$this->load->model('utils/return_format');
		$accountdb = $this->load->database('accountdb', TRUE);
		
		$serverId = $this->input->post('server_id');
		if(!empty($serverId))
		{
			$sql = "SELECT `account_job`, count(*) as `count` FROM `web_account` WHERE `server_id`='{$serverId}' GROUP BY `account_job`";
		}
		else
		{
			$sql = "SELECT `account_job`, count(*) as `count` FROM `web_account` GROUP BY `account_job`";
		}
		$result = $accountdb->query($sql)->result_array();
		for($i=0; $i<count($result); $i++)
		{
			$result[$i]['account_job'] = lang('behavior_job_' . $result[$i]['account_job']);
			$result[$i] = array_values($result[$i]);
		}
		
		echo $this->return_format->format($result);
	}
}

?>