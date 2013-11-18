<?php
class Consume extends CI_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this->load->model ( 'utils/return_format' );
	}
	
	public function get_equipment_name($format = 'json')
	{
		$type = $this->input->post('type');
		
		if(!empty($type))
		{
			$parameter = array(
					'type'	=>	intval($type)
			);
		}
		$this->load->model('mequipmentname');
		$result = $this->mequipmentname->read($parameter);
		$data = array(
				'type'		=>	$type,
				'result'	=>	$result
		);
		echo $this->return_format->format($data, $format);
	}
}

?>