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
		$content = '号外号外！《冰火王座》封测版游戏攻略征集活动开启啦，每位尊贵的封测玩家都有资格参加这一活动！游戏达人们，快快将你们的游戏心得整理成菜鸟也能看懂的详尽图文攻略吧！我们将会把本次活动征集上来的优秀稿件发布在官网攻略区，并给予入选者丰厚的奖励，有Ipad mini2可以拿哦！还等什么，快点跟大家一起分享你的游戏经验吧！更多详情请加入冰火官方群：38820749';
		
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