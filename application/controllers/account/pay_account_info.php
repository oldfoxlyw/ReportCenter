<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pay_account_info extends CI_Controller
{
	private $pageName = 'account/pay_account_info';
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
		$this->load->model ( 'mserver' );

		$serverResult = $this->mserver->read ();
		
		$data = array(
			'admin'				=>	$this->user,
			'page_name'			=>	$this->pageName,
			'server_result' 	=>	$serverResult,
			'current_time'		=>	time()
		);
		$this->render->render($this->pageName, $data);
	}
	
	public function lists($provider = 'datatable')
	{
		$this->load->model('utils/return_format');
		
		$serverId = $this->input->post('serverId');
		$accountId = $this->input->post('accountId');
		$accountName = $this->input->post('accountName');

		$data = array();
		if(!empty($serverId) && (!empty($accountId) || !empty($accountName)))
		{
			$this->load->model('maccount');
			$this->load->model('mpaidaccount');
			if(!empty($accountId))
			{
				$parameter = array(
					'GUID'		=>	$accountId
				);
			}
			else
			{
				$parameter = array(
					'server_id'			=>	$serverId,
					'account_nickname'	=>	$accountName
				);
			}
			$result = $this->maccount->read($parameter);
			if(!empty($result))
			{
				$guid = $result[0]->GUID;
				$info = $this->mpaidaccount->read(array(
					'guid'	=>	$guid
				));
				$row = array_merge((array)$result[0], (array)$info[0]);
				array_push($data, $row);
			}

			for($i = 0; $i < count($data); $i++)
			{
				$data[$i]['account_regtime'] = date('Y-m-d H:i:s', $data[$i]['account_regtime']);
				$data[$i]['account_lastlogin'] = date('Y-m-d H:i:s', $data[$i]['account_lastlogin']);
				$data[$i]['first_paid_time'] = date('Y-m-d H:i:s', $data[$i]['first_paid_time']);
				$data[$i]['last_paid_time'] = date('Y-m-d H:i:s', $data[$i]['last_paid_time']);
			}
		}
		
		echo $this->return_format->format($data);
	}
}

?>