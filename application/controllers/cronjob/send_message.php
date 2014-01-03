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
		
		$ip = 'http://183.60.255.57:8091';
		$content = '尊敬的各位玩家，《冰火王座》临近正式上线，原测试服红龙女王，将于1月4号晚24时关闭，越狱渠道封测将于10号开启，有许多新的活动和奖品，欢迎各位新老家去试玩！更多信息以及详情请关注官网！bhwz.zqgame.com';
		
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