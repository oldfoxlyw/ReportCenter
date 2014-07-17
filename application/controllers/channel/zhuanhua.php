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
		$data = array(
			'admin'			=>	$this->user,
			'page_name'		=>	$this->pageName,
			'current_time'	=>	time()
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
		$starttime = $this->input->get_post('starttime');
		$endtime = $this->input->get_post('endtime');

		$limit = $limit < 0 ? 25 : $limit;
		if(!empty($starttime))
		{
			$channeldb->where('time >=', "{$starttime} 00:00:00");
		}
		if(!empty($endtime))
		{
			$channeldb->where('time <=', "{$endtime} 23:59:59");
		}
		$count = $channeldb->count_all_results('click_table');

		if(!empty($starttime))
		{
			$channeldb->where('time >=', "{$starttime} 00:00:00");
		}
		if(!empty($endtime))
		{
			$channeldb->where('time <=', "{$endtime} 23:59:59");
		}
		$channeldb->order_by('time', 'desc');
		$channeldb->limit($limit);
		$channeldb->offset($offset);
		$result = $channeldb->get('click_table');
		// $result = $channeldb->query("select * from click_table order by time desc limit {$limit} offset {$offset}");
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
		$starttime = $this->input->get_post('starttime');
		$endtime = $this->input->get_post('endtime');

		$limit = $limit < 0 ? 25 : $limit;
		if(!empty($starttime))
		{
			$channeldb->where('date >=', $starttime);
		}
		if(!empty($endtime))
		{
			$channeldb->where('date <=', $endtime);
		}
		$count = $channeldb->count_all_results('valid_click');

		if(!empty($starttime))
		{
			$channeldb->where('date >=', $starttime);
		}
		if(!empty($endtime))
		{
			$channeldb->where('date <=', $endtime);
		}
		$channeldb->order_by('date', 'desc');
		$channeldb->limit($limit);
		$channeldb->offset($offset);
		$result = $channeldb->get('valid_click');
		$result = $result->result();

		$data = array(
				'sEcho'						=>	$sEcho,
				'iTotalRecords'				=>	$count,
				'iTotalDisplayRecords'		=>	$count,
				'aaData'					=>	$result
		);
		
		echo $this->return_format->format($data);
	}

	public function get_count()
	{
		$this->load->model('utils/return_format');

		$starttime = $this->input->get_post('starttime');
		$endtime = $this->input->get_post('endtime');

		$channeldb = $this->load->database('channeldb', TRUE);
		if(!empty($starttime))
		{
			$channeldb->where('time >=', "{$starttime} 00:00:00");
		}
		if(!empty($endtime))
		{
			$channeldb->where('time <=', "{$endtime} 23:59:59");
		}
		$click_count = $channeldb->count_all_results('click_table');

		if(!empty($starttime))
		{
			$channeldb->where('date >=', $starttime);
		}
		if(!empty($endtime))
		{
			$channeldb->where('date <=', $endtime);
		}
		$valid_click_count = $channeldb->count_all_results('valid_click');

		$data = array(
			'click_count'		=>	$click_count,
			'valid_click_count'	=>	$valid_click_count
		);
		
		echo $this->return_format->format($data);
	}
}

?>