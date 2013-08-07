<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller
{
	private $pageName = 'index';
	private $user = null;
	
	public function __construct()
	{
		parent::__construct ();
		$this->load->model('utils/check_user', 'check');
		$this->user = $this->check->validate();
	}
	
	public function index()
	{
		$data = array(
			'admin'			=>	$this->user,
			'page_name'	=>	$this->pageName
		);
		$this->render->render($this->pageName, $data);
	}
	
	public function lists($provider = 'highchart')
	{
		$this->load->model('moverview');
		$this->load->model('utils/return_format');
		
		$currentTime = time();
		$lastTime = $currentTime - 86400;
		$lastDate = date('Y-m-d', $lastTime) . ' 23:59:59';
		$sevenDaysAgoTime = $lastTime - 7 * 86400;
		$sevenDaysAgoDate = date('Y-m-d', $sevenDaysAgoTime) . ' 00:00:00';
		
		$parameter = array(
			'log_date >='		=>	$sevenDaysAgoDate,
			'log_date <='		=>	$lastDate
		);
		$result = $this->moverview->read($parameter);
		
		$data = array();
		$data['axis'] = array();
		
		foreach($result as $row)
		{
			if(empty($data[$row->server_name]))
			{
				$data[$row->server_name] = array();
			}
			array_push($data[$row->server_name], $row);
			
			if(!in_array($row->log_date, $data['axis']))
			{
				array_push($data['axis'], $row->log_date);
			}
		}
		
		echo $this->return_format->format($data);
	}
}

?>