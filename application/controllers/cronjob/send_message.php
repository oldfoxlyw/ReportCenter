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
		$content = '《冰火王座》封测版将于11月26日16时左右进行停服更新，时间预计为1小时，更新期间服务器将无法登入。更新后请各位玩家务必前往官方网站http://www.tapdk.com/下载最新客户端，否则将无法正常进行游戏。对此给您造成的不便敬请谅解，具体更新内容请查看登陆界面的新闻公告。';
		
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