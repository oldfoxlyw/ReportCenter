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