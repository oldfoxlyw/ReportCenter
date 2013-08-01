<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administrators extends CI_Controller
{
	private $pageName = 'administrators';
	private $user = null;
	
	public function __construct()
	{
		parent::__construct ();
		$this->load->model('utils/check_user', 'check');
		$this->user = $this->check->validate();
	}
	
	public function index()
	{
		$this->load->model('madmin');
		
		$parameter = null;
		if($this->user->user_founder != '1')
		{
			$parameter = array(
				'GUID'		=>	$this->user->GUID
			);
		}
		$result = $this->madmin->read($parameter);
		$data = array(
			'admin'					=>	$this->user,
			'page_name'			=>	$this->pageName,
			'result'					=>	$result,
		);
		$this->render->render($this->pageName, $data);
	}
	
	public function edit($adminId = 0)
	{
		if(!empty($adminId))
		{
			if($this->user->user_founder != '1' && $this->user->GUID != $adminId)
			{
				showMessage(MESSAGE_TYPE_ERROR, 'USER_NO_PERMISSION', '', 'administrators', true, 5);
			}
			$this->load->model('madmin');
			$result = $this->madmin->read(array(
				'GUID'		=>	$adminId
			));
			if($result !== FALSE)
			{
				$result = $result[0];
			}
			
			$data = array(
				'admin'					=>	$this->user,
				'page_name'			=>	$this->pageName,
				'edit'					=>	'1',
				'admin_id'			=>	$adminId,
				'value'					=>	$result
			);
			$this->render->render($this->pageName, $data);
		}
	}
	
	public function delete($adminId = 0)
	{
		if(!empty($adminId))
		{
			if($this->user->user_founder != '1')
			{
				showMessage(MESSAGE_TYPE_ERROR, 'USER_NO_PERMISSION', '', 'administrators', true, 5);
			}
			$this->load->model('madmin');
			
			$result = $this->madmin->read(array(
				'GUID'		=>	$adminId
			));
			if(!empty($result))
			{
				$row = $result[0];
				if($row->user_founder == '1')
				{
					showMessage(MESSAGE_TYPE_ERROR, 'USER_DELETE_FORBIDDEN', '', 'administrators', true, 5);
				}
			}
			$this->madmin->delete($adminId);
		}
		redirect('account');
	}
	
	public function submit()
	{
		$this->load->model('madmin');
		$this->load->helper('security');
		
		$edit = $this->input->post('edit', TRUE);
		$adminId = $this->input->post('adminId', TRUE);
		$adminAccount = $this->input->post('adminAccount', TRUE);
		$adminPass = $this->input->post('adminPass', TRUE);

		if($this->user->user_founder != '1' && $this->user->GUID != $adminId)
		{
			showMessage(MESSAGE_TYPE_ERROR, 'USER_NO_PERMISSION', '', 'administrators', true, 5);
		}
		
		if(empty($adminAccount) || (empty($edit) && empty($adminPass)))
		{
			showMessage(MESSAGE_TYPE_ERROR, 'NO_PARAM', '', 'administrators', true, 5);
		}
		
		$row = array(
			'user_name'		=>	$adminAccount
		);
		
		if(!empty($edit))
		{
			if(!empty($adminPass))
			{
				$row['user_pass'] = encrypt_pass($adminPass);
			}
			$this->madmin->update($adminId, $row);
		}
		else
		{
			$row['user_pass'] = encrypt_pass($adminPass);
			$this->madmin->create($row);
		}
		redirect('administrators');
	}
}

?>