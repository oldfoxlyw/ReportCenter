<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Check_user extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('madmin');
	}
	
	public function validate($redirect = true) {
		$this->load->helper('security');
		$this->load->helper('cookie');
		$redirectUrl = 'login?redirect=' . urlencode($this->input->server('REQUEST_URI'));
		$cookieName = $this->config->item('cookie_prefix') . 'admin';
		if(!$this->input->cookie($cookieName, TRUE)) {

			if($redirect)
				showMessage(MESSAGE_TYPE_ERROR, 'USER_CHECK_EXPIRED', '', $redirectUrl, true, 5);
			
		} else {
			$cookie = $this->input->cookie($cookieName, TRUE);
			$cookie = _authcode($cookie);
			$json = json_decode($cookie);
			$id = $json->admin_id;
			$parameter = array(
				'GUID'	=>	$id
			);
			$result = $this->madmin->read($parameter);
			if($result != FALSE) {
				
				return $result[0];
			} else {

				$this->resetCookie();
				if($redirect)
				{
					showMessage(MESSAGE_TYPE_ERROR, 'USER_CHECK_INVALID', '', $redirectUrl, true, 5);
				}
				
			}
		}
	}
	
	private function resetCookie()
	{
		$this->load->helper('cookie');
		$cookie = array(
			'name'		=> 'admin',
			'domain'	=> $this->config->item('cookie_domain'),
			'path'		=> $this->config->item('cookie_path'),
			'prefix'		=> $this->config->item('cookie_prefix')
		);
		delete_cookie($cookie);
	}
}
?>