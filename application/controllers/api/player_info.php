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
		$this->load->model('maccount');
		
		$parameter = array(
				'server_id'		=>	'A',
				'account_job'	=>	''
		);
		$result = $this->maccount->read($parameter);

		header('Content-type:text/json');
		echo json_encode($result);
	}
	
	public function get_info_by_guid()
	{
		$this->load->model('maccount');
		$this->load->model('utils/connector');
		
		$guid = $this->input->get_post('guid');
		
		if(!empty($guid))
		{
			$data = $this->connector->post('http://115.29.195.156:8090/query_player_info', array(
					'player_id'	=>	$guid
			), false);
			
			$json = json_decode($data);
			if(!empty($json))
			{
				$parameter = array(
						'account_job'		=>	$json->job,
						'account_level'		=>	$json->level,
						'account_mission'	=>	($json->mission == 'null' || empty($json->mission)) ? '' : $json->mission
				);
				$this->maccount->update($guid, $parameter);
			}
			echo $data;
		}
	}
}

?>