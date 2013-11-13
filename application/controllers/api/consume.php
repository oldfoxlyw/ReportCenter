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
		$this->load->model('mequipmentname');
		$result = $this->mequipmentname->read();
		echo $this->return_format->format($result, $format);
	}
}

?>