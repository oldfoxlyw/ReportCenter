<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SystemHook
{
	private $CI;

	public function __construct()
	{
		$this->CI =& get_instance();
	}

	public function checkIp()
	{
		$ips = $this->CI->config->item('allowed_ips');
		if(!empty($ips))
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