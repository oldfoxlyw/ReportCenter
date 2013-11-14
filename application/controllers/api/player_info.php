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
		$parameter = array(
				'account_job !='	=>	''
		);
		$result = $this->maccount->read($parameter);
		var_dump($result);
		exit();
		
		for($i = 0; $i<10; $i++)
		{
			$guid = $result[$i]->GUID;
			$data = $this->connector->post('http://115.29.195.156:8090/query_player_info', array(
					'player_id'	=>	$guid
			));
			var_dump($data);
			echo '<br><br><br>';
		}
	}
}

?>