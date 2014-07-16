<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Zhuanhua extends CI_Controller
{
	private $pageName = 'channel/zhuanhua';
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
		$this->load->model('mserver');
		
		$serverResult = $this->mserver->read();
		$data = array(
			'admin'			=>	$this->user,
			'page_name'	=>	$this->pageName,
			'server'			=>	$serverResult
		);
		$this->render->render($this->pageName, $data);
	}
	
	public function lists($provider = 'highchart')
	{
		$this->load->model('utils/return_format');
		$channeldb = $this->load->database('channeldb', TRUE);
		
		$sEcho = $this->input->get_post('sEcho');
		$offset = $this->input->get_post('iDisplayStart');
		$limit = $this->input->get_post('iDisplayLength');
		$keyword = $this->input->get_post('sSearch');

		$limit = $limit < 0 ? 25 : $limit;
		$count = $channeldb->count_all_results('click_table');

		$result = $channeldb->query("select * from click_table order by time desc limit {$limit} offset {$offset}");
		$result = $result->result();

		$data = array(
				'sEcho'						=>	$sEcho,
				'iTotalRecords'				=>	$count,
				'iTotalDisplayRecords'		=>	$count,
				'aaData'					=>	$result
		);
		
		echo $this->return_format->format($data);
	}

	public function zhuanhua_list()
	{
		$this->load->model('utils/return_format');
		$channeldb = $this->load->database('channeldb', TRUE);
		
		$sEcho = $this->input->get_post('sEcho');
		$offset = $this->input->get_post('iDisplayStart');
		$limit = $this->input->get_post('iDisplayLength');
		$keyword = $this->input->get_post('sSearch');

		$limit = $limit < 0 ? 25 : $limit;
		$count = $channeldb->count_all_results('valid_click');

		$result = $channeldb->query("select * from valid_click group by ip order by date desc limit {$limit} offset {$offset}");
		$result = $result->result();

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