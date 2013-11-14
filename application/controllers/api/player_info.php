<?php
class Player_info extends CI_Controller
{
	private $pageName = 'api/player_info';
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
		$this->load->view($this->pageName);
	}
	
	public function get_invalid_player()
	{
		$parameter = array(
				'server_id'		=>	A,
				'account_job'	=>	''
		);
		$result = $this->maccount->read($parameter, null, 10);

		header('Content-type:text/json');
		echo json_encode($result);
	}
	
	public function get_info_by_guid()
	{
		$this->load->model('maccount');
		$this->load->model('utils/connector');
		
		$parameter = array(
				'account_job'	=>	''
		);
		$result = $this->maccount->read($parameter, null, 10);
		
		for($i = 0; $i<10; $i++)
		{
			$guid = $result[$i]->GUID;
			$data = $this->connector->post('http://112.124.37.58:8090/query_player_info', array(
					'player_id'	=>	3024
			), false);
			var_dump($data);
			echo '<br><br><br>';
		}
	}
}

?>