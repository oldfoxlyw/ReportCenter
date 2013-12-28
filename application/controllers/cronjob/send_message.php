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
		$content = '冰火王座盛大开测，7*24小时劲爆活动惊喜乐不停！每晚11点55，免费抢宝石！每天上午12点和晚上8点，全区狂欢，抢夺极品红包！关注冰火王座官方网站(bhwz.zqgame.com)，加入冰火官方群（38820749），尽享更多精彩活动内容！';
		
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