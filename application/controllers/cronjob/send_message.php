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
		
		$ip = 'http://115.29.195.156:8090';
		$content = '临近公测，《冰火王座》封测版游戏攻略征集活动中奖名单也火热出炉啦，快加入冰火官方群（38820749），联系群主“冰火”，看看有没有你的名字吧！';
		
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