<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Buy_equipment extends CI_Controller
{
	private $pageName = 'order/buy_equipment';
	private $user = null;

	public function __construct()
	{
		parent::__construct ();
		$this->load->model ( 'utils/check_user', 'check' );
		$this->user = $this->check->validate ();
		$this->check->permission ( $this->pageName );
	}

	public function index()
	{
		$this->load->model ( 'mserver' );
		
		$serverResult = $this->mserver->read ();
		$data = array (
			'admin' => $this->user,
			'page_name' => $this->pageName,
			'server_result' => $serverResult,
			'current_time' => time () 
		);
		$this->render->render ( $this->pageName, $data );
	}

	public function lists($provider = 'highchart')
	{
		$this->load->model ( 'mbuyequipment' );
		$this->load->model ( 'utils/return_format' );
		
		$serverId = $this->input->post ( 'serverId' );
		$logDate = $this->input->post ( 'startTime' );
		$itemType = $this->input->post ( 'itemType' );
		
		$parameter = array (
			'server_id' => $serverId,
			'date' => $logDate,
			// 'partner_key' => $this->user->user_fromwhere 
		);
		$result = $this->mbuyequipment->read ( $parameter );
		
		$parameter = array ();
		
		if ($result !== FALSE)
		{
			foreach ($result as $row)
			{
				// $row = $result [0];
				$detail = json_decode ( $row->level_detail );
				if (empty ( $itemType ))
				{
					foreach ( $detail as $key => $value )
					{
						if(!empty($value))
						{
							$value = explode ( ',', $value );
							foreach ( $value as $row )
							{
								$row = explode ( ':', $row );
								$parameter [$key] [$row [0]] += $row [1];
							}
						}
						else
						{
							$parameter [$key] = "";
						}
					}
				} else
				{
					$detail = $detail->{$itemType};
					$detail = explode ( ',', $detail );
					foreach ( $detail as $row )
					{
						$row = explode ( ':', $row );
						$parameter ["{$itemType}"] [$row [0]] += $row [1];
					}
				}
			}
		} else
		{
			$parameter = array ();
		}
		
		echo $this->return_format->format ( $parameter );
	}
}

?>