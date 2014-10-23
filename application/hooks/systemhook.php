<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SystemHook
{
	private $CI;

	public function __construct()
	{
		$this->CI =& get_instance();
	}

	public function checkAvailable()
	{
		$this->CI->load->model('mwebconfig');
		$result = $this->CI->mwebconfig->read(array(
			'config_id'		=>	1
		));
		if(!empty($result))
		{
			$row = $result[0];
			if($row->config_close_scc == '1')
			{
				$this->CI->load->helper('url');
				redirect('resources/close.html');
				return;
			}
		}
	}
}