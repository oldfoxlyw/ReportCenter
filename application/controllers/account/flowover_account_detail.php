<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Flowover_account_detail extends CI_Controller
{
	private $pageName = 'account/flowover_account_detail';
	private $user = null;

	public function __construct()
	{
		parent::__construct ();
		$this->load->model ( 'utils/check_user', 'check' );
		$this->user = $this->check->validate ();
		$this->check->permission($this->pageName);
	}

	public function index()
	{
		$this->load->model ( 'mserver' );
		$this->load->model('mpartner');

		$serverResult = $this->mserver->read ();
		$partnerResult = $this->mpartner->read();
		
		$data = array (
			'admin' 			=> $this->user,
			'page_name' 		=> $this->pageName,
			'current_time' 		=> time (),
			'server_result' 	=> $serverResult,
			'partner_result'	=> $partnerResult
		);
		$this->render->render ( $this->pageName, $data );
	}

	public function lists($provider = 'highchart')
	{
		$this->load->helper('language');
		$this->lang->load('job');
		$this->load->model ( 'mflowoverdetail' );
		$this->load->model ( 'utils/return_format' );
		
		$startTime = $this->input->post ( 'startTime' );
		$serverId = $this->input->post ( 'serverId' );
		$partnerKey = $this->input->post('partnerKey');
		
		if (! empty ( $serverId ))
		{
			if (empty ( $startTime ))
			{
				$startTime = time () - 86400;
				$startTime = date ( 'Y-m-d', $startTime );
			}
			$parameter = array (
				'date'			=>	$startTime,
				'server_id'		=>	$serverId
			);
			if(!empty($partnerKey))
			{
				$parameter['partner_key'] = $partnerKey;
			}
			$result = $this->mflowoverdetail->read ( $parameter );
			$result = $result [0];
			
			$jobArray = array ();
			$job = explode ( ',', $result->job );
			foreach ( $job as $j )
			{
				$j = explode ( ':', $j );
				$j[0] = lang('behavior_job_' . $j[0]);
				if(!$j[0]) $j[0] = '';
				array_push ( $jobArray, $j );
			}
			$levelArray = array ();
			$level = explode ( ',', $result->level );
			foreach ( $level as $l )
			{
				$l = explode ( ':', $l );
				array_push ( $levelArray, $l );
			}
			$missionArray = array ();
			$mission = explode ( ',', $result->mission );
			foreach ( $mission as $m )
			{
				$m = explode ( ':', $m );
				array_push ( $missionArray, $m );
			}
			
			$parameter = array (
				'date'			=>	$startTime,
				'server_id'		=>	$serverId,
				'job'				=>	$jobArray,
				'level'			=>	$levelArray,
				'mission'		=>	$missionArray 
			);
			
			echo $this->return_format->format ( $parameter );
		}
	}
}

?>