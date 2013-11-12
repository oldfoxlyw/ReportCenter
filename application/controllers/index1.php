<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index1 extends CI_Controller
{
	private $pageName = 'index1';
	private $user = null;
	
	public function __construct()
	{
		parent::__construct ();
		$this->load->model('utils/check_user', 'check');
		$this->user = $this->check->validate();
	}
	
	public function index()
	{
		$this->load->model('mserver');
		$serverResult = $this->mserver->read(array(
				'server_debug'		=>	0,
				'server_status !='	=>	9,
				'partner'			=>	$this->user->user_fromwhere
		));
		$data = array(
			'admin'			=>	$this->user,
			'page_name'		=>	$this->pageName,
			'server'		=>	$serverResult
		);
		$this->render->render($this->pageName, $data);
	}
	
	public function lists($provider = 'highchart')
	{
		$this->load->model('moverview');
		$this->load->model('utils/return_format');
		$logcachedb = $this->load->database('logcachedb', TRUE);
		
		$serverId = $this->input->get('server_id');
		$sEcho = $this->input->get_post('sEcho');
		$offset = $this->input->get_post('iDisplayStart');
		$limit = $this->input->get_post('iDisplayLength');
		$keyword = $this->input->get_post('sSearch');
		
		$currentTime = time();
		$lastTime = $currentTime - 86400;
		$lastDate = date('Y-m-d', $lastTime) . ' 23:59:59';
		$sevenDaysAgoTime = $lastTime - 7 * 86400;
		$sevenDaysAgoDate = date('Y-m-d', $sevenDaysAgoTime) . ' 00:00:00';
		
		$sql = "SELECT COUNT(*) as `numrows` FROM `log_daily_statistics` WHERE `log_date`>='{$sevenDaysAgoDate}' AND `log_date`<='{$lastDate}' AND `server_id`='{$serverId}' AND `partner_key`='{$this->user->user_fromwhere}'";
		$count = $logcachedb->query($sql)->row();
		$count = $count->numrows;
		
		$sql = "SELECT * FROM `log_daily_statistics` WHERE `log_date`>='{$sevenDaysAgoDate}' AND `log_date`<='{$lastDate}' AND `server_id`='{$serverId}' AND `partner_key`='{$this->user->user_fromwhere}'";
		$result = $logcachedb->query($sql)->result();
		
		$sql = "SELECT * FROM `log_retention` WHERE `log_date`>='{$sevenDaysAgoDate}' AND `log_date`<='{$lastDate}' AND `server_id`='{$serverId}' AND `partner_key`='{$this->user->user_fromwhere}'";
		$retention = $logcachedb->query($sql)->result();
		
		$retentionResult = array();
		foreach($retention as $row)
		{
			$retentionResult[$row->log_date . '_' . $row->server_id . '_' . $row->partner_key] = $row;
		}
		
		for($i=0; $i<count($result); $i++)
		{
			$re = $retentionResult[$result[$i]->log_date . '_' . $result[$i]->server_id . '_' . $result[$i]->partner_key];
			if(!empty($re))
			{
				$result[$i]->prev_current_login = $re->prev_current_login;
				$result[$i]->third_current_login = $re->third_current_login;
				$result[$i]->next_retention = $re->next_retention;
				$result[$i]->third_retention = $re->third_retention;
			}
			else
			{
				$result[$i]->prev_current_login = '-';
				$result[$i]->third_current_login = '-';
				$result[$i]->next_retention = '-';
				$result[$i]->third_retention = '-';
			}
		}

		$data = array(
				'sEcho'						=>	$sEcho,
				'iTotalRecords'				=>	$count,
				'iTotalDisplayRecords'		=>	$count,
				'aaData'					=>	$result
		);
		
		echo $this->return_format->format($data);
	}
}

?>