<?php
class Equipment_detail extends CI_Controller
{
	private $pageName = 'order/equipment_detail';
	private $user = null;
	
	public function __construct()
	{
		parent::__construct ();
		$this->load->model ( 'utils/check_user', 'check' );
		$this->user = $this->check->validate ();
		$this->check->permission ( $this->pageName );
	}
	
	public function index()
	{
		$this->load->model ( 'mserver' );
		
		$serverResult = $this->mserver->read ();
		$data = array (
			'admin' => $this->user,
			'page_name' => $this->pageName,
			'server_result' => $serverResult,
			'current_time' => time()
		);
		$this->render->render ( $this->pageName, $data );
	}
}

?>