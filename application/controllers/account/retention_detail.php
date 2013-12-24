<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Retention_detail extends CI_Controller
{
	private $pageName = 'account/retention_detail';
	private $user = null;

	public function __construct()
	{
		parent::__construct ();
		$this->load->model('utils/check_user', 'check');
		$this->user = $this->check->validate();
		$this->check->permission($this->pageName);
	}
	
	public function index()
	{
		$data = array(
			'admin'					=>	$this->user,
			'page_name'			=>	$this->pageName,
			'current_time'		=>	time(),
		);
		$this->render->render($this->pageName, $data);
	}
	
	public function lists($provider = 'datatable')
	{
		$this->load->model('utils/return_format');
		$logcachedb = $this->load->database('logcachedb', TRUE);
		
		$serverId = $this->input->get('server_id');
		
		$currentTime = time();
		$lastTime = $currentTime - 86400;
		$lastDate = date('Y-m-d', $lastTime) . ' 23:59:59';
		$sevenDaysAgoTime = $lastTime - 6 * 86400;
		$sevenDaysAgoDate = date('Y-m-d', $sevenDaysAgoTime) . ' 00:00:00';
		
		$sql = "SELECT * FROM `log_daily_statistics` WHERE `log_date`>='{$sevenDaysAgoDate}' AND `log_date`<='{$lastDate}' AND `server_id`='{$serverId}' AND `partner_key`='{$this->user->user_fromwhere}' ORDER BY `log_date` DESC";
		$result = $logcachedb->query($sql)->result();
		
		if($provider == 'retention')
		{
			$sql = "SELECT * FROM `log_retention1` WHERE `log_date`>='{$sevenDaysAgoDate}' AND `log_date`<='{$lastDate}' AND `server_id`='{$serverId}' AND `partner_key`='{$this->user->user_fromwhere}' ORDER BY `log_date` DESC";
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
					$result[$i]->next_current_login = $re->next_current_login;
					$result[$i]->third_current_login = $re->third_current_login;
					$result[$i]->third_current_login_range = $re->third_current_login_range;
					$result[$i]->seven_current_login = $re->seven_current_login;
					$result[$i]->seven_current_login_range = $re->seven_current_login_range;
					$result[$i]->seven_current_login_huge = $re->seven_current_login_huge;
					$result[$i]->next_retention = $re->next_retention;
					$result[$i]->third_retention = $re->third_retention;
					$result[$i]->third_retention_range = $re->third_retention_range;
					$result[$i]->seven_retention = $re->seven_retention;
					$result[$i]->seven_retention_range = $re->seven_retention_range;
					$result[$i]->seven_retention_huge = $re->seven_retention_huge;
				}
				else
				{
					$result[$i]->next_current_login = '-';
					$result[$i]->third_current_login = '-';
					$result[$i]->third_current_login_range = '-';
					$result[$i]->seven_current_login = '-';
					$result[$i]->seven_current_login_range = '-';
					$result[$i]->seven_current_login_huge = '-';
					$result[$i]->next_retention = '-';
					$result[$i]->third_retention = '-';
					$result[$i]->third_retention_range = '-';
					$result[$i]->seven_retention = '-';
					$result[$i]->seven_retention_range = '-';
					$result[$i]->seven_retention_huge = '-';
				}
			}
		}

		$data = array(
				'aaData'					=>	$result
		);
		
		echo $this->return_format->format($data);
	}
}

?>