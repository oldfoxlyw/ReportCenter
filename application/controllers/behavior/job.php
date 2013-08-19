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
		
		$startTime = $this->input->post('startTime');
		$endTime = $this->input->post('endTime');
		
		if(empty($startTime) || empty($endTime))
		{
			$endTime = time() - 86400;
			$startTime = $endTime - 7 * 86400;
			$startTime = date('Y-m-d', $startTime);
			$endTime = date('Y-m-d', $endTime);
		}
		else
		{
			$start = strtotime($startTime . ' 00:00:00');
			$end = strtotime($endTime . ' 23:59:59');
			if($start > $end || empty($start) || empty($end))
			{
				
			}
		}
		$parameter = array(
			'log_date >='		=>	$startTime,
			'log_date <='		=>	$endTime
		);
		$extension = array(
			'select'		=>	array(
				'log_date',
				'server_name',
				'modify_new_account'
			)
		);
		$result = $this->moverview->read($parameter, $extension);
		
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