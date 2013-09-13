<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Permission extends CI_Controller
{
	private $pageName = 'permission';
	private $user = null;
	
	public function __construct()
	{
		parent::__construct ();
		$this->load->model('utils/check_user', 'check');
		$this->user = $this->check->validate();
	}
	
	public function index()
	{
		$data = array(
			'admin'					=>	$this->user,
			'page_name'			=>	$this->pageName
		);
		$this->render->render($this->pageName, $data);
	}
	
	public function lists()
	{
		$this->load->model('madmin');
		$this->load->model('utils/return_format');
		
		$sEcho = $this->input->get_post('sEcho');
		$offset = $this->input->get_post('iDisplayStart');
		$limit = $this->input->get_post('iDisplayLength');
		$keyword = $this->input->get_post('sSearch');

		$parameter = null;
		if($this->user->user_founder != '1')
		{
			$parameter = array(
				'GUID'		=>	$this->user->GUID
			);
		}
		
		$extension = null;
		if(!empty($keyword))
		{
			$like = array(
				array('GUID', $keyword),
				array('user_name', $keyword),
				array('permission_name', $keyword)
			);
			$extension['like'] = $like;
		}
		$count = $this->madmin->count($parameter);
		$result = $this->madmin->read($parameter, $extension, $limit, $offset);
		$data = array(
			'sEcho'							=>	$sEcho,
			'iTotalRecords'				=>	$count,
			'iTotalDisplayRecords'	=>	$count,
			'aaData'						=>	$result
		);
		
		echo $this->return_format->format($data);
	}
	
	public function add()
	{
		$this->load->model('mpermission');
		$permissions = $this->mpermission->read();
		$this->pageName = 'permission_add';
		
		$data = array(
			'admin'					=>	$this->user,
			'page_name'			=>	$this->pageName,
			'permissions'		=>	$permissions
		);
		$this->render->render($this->pageName, $data);
	}
	
	public function edit($adminId = 0)
	{
		if(!empty($adminId))
		{
			$this->pageName = 'permission_add';
			if($this->user->user_founder != '1' && $this->user->GUID != $adminId)
			{
				showMessage(MESSAGE_TYPE_ERROR, 'USER_NO_PERMISSION', '', 'permission', true, 5);
			}
			$this->load->model('madmin');
			$this->load->model('mpermission');
			$permissions = $this->mpermission->read();
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
				'value'					=>	$result,
				'permissions'		=>	$permissions
			);
			$this->render->render($this->pageName, $data);
		}
		else
		{
			showMessage(MESSAGE_TYPE_ERROR, 'NO_PARAM', '', 'administrators', true, 5);
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
			redirect('administrators');
		}
		else
		{
			showMessage(MESSAGE_TYPE_ERROR, 'NO_PARAM', '', 'administrators', true, 5);
		}
	}
	
	public function submit()
	{
		$this->load->model('madmin');
		$this->load->helper('security');
		
		$edit = $this->input->post('edit', TRUE);
		$adminId = $this->input->post('adminId', TRUE);
		$adminAccount = $this->input->post('adminAccount', TRUE);
		$adminPass = $this->input->post('adminPass', TRUE);
		$userPermission = $this->input->post('userPermission', TRUE);

		if($this->user->user_founder != '1' && $this->user->GUID != $adminId)
		{
			showMessage(MESSAGE_TYPE_ERROR, 'USER_NO_PERMISSION', '', 'administrators', true, 5);
		}
		
		if(empty($adminAccount) || (empty($edit) && empty($adminPass)))
		{
			showMessage(MESSAGE_TYPE_ERROR, 'NO_PARAM', '', 'administrators', true, 5);
		}
		
		$row = array(
			'user_name'			=>	$adminAccount,
			'user_permission'	=>	$userPermission
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