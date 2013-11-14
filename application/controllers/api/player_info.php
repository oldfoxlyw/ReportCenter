<?php
class Player_info extends CI_Controller
{
	public function __construct()
	{
		parent::__construct ();
	}
	
	public function get_info_by_guid()
	{
		$this->load->model('maccount');
		$this->load->model('utils/connector');
		

		$data = $this->connector->post('http://112.124.37.58:8090/query_player_info', array(
				'player_id'	=>	3024
		));
		var_dump($data);
		exit();
		
		$parameter = array(
				'account_job'	=>	''
		);
		$result = $this->maccount->read($parameter, null, 10);
		
		for($i = 0; $i<10; $i++)
		{
			$guid = $result[$i]->GUID;
			$data = $this->connector->post('http://112.124.37.58:8090/query_player_info', array(
					'player_id'	=>	3024
			));
			var_dump($data);
			echo '<br><br><br>';
		}
	}
}

?>