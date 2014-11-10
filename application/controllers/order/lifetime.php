<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lifetime extends CI_Controller
{
	private $pageName = 'order/lifetime';
	private $user = null;
	
	public function __construct()
	{
		parent::__construct ();
		$this->load->model('utils/check_user', 'check');
		$this->user = $this->check->validate ();
		$this->check->permission ( $this->pageName );
	}

	public function index()
	{
		$this->load->model('mserver');
		$this->load->model('mpartner');
		$partnerResult = $this->mpartner->read();
		$serverResult = $this->mserver->read(array(
				'server_debug'		=>	0,
				'server_status !='	=>	9
		));
		
		$data = array(
			'admin'				=>	$this->user,
			'page_name'			=>	$this->pageName,
			'server_result'		=>	$serverResult,
			'current_time'		=>	time(),
			'partner_result'	=>	$partnerResult
		);
		$this->render->render($this->pageName, $data);
	}

	public function lists($format = 'json')
	{
		$serverId = $this->input->post('serverId');
		$startTime = $this->input->post('startTime');
		$endTime = $this->input->post('endTime');
		$partnerKey = $this->input->post('partnerKey');

		$this->load->model('mlifetime');
		$parameter = array();
		if(!empty($serverId))
		{
			$parameter['server_id'] = $serverId;
		}
		if(!empty($startTime) && !empty($endTime))
		{
			$parameter['date >='] = $startTime;
			$parameter['date <='] = $endTime;
		}
		if(!empty($partnerKey))
		{
			$parameter['partner_key'] = $partnerKey;
		}

		$result = $this->mlifetime->read($parameter);

		$this->load->model('utils/return_format');
		echo $this->return_format->format($result);
	}
}