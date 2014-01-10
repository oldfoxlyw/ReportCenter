<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Send_message extends CI_Controller
{

	public function __construct()
	{
		parent::__construct ();
	}
	
	public function send()
	{
		$this->load->model('utils/connector');
		
		$ip = 'http://183.60.255.76:8091';
		$content = '亲爱的各位玩家，欢迎参加本次技术封测，本次删档测试暂不开放充值功能，请不要相信任何形式的代充、兜售绿钻的虚假信息，谨防上当受骗。';
		
		if(!empty($ip) && !empty($content))
		{
			$parameter = array(
				'content'			=>	$content
			);
			echo $this->connector->post($ip . '/announcement', $parameter, FALSE);
		}
	}
}

?>