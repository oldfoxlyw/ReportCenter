<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('ICrud.php');

class Monlinecount extends CI_Model implements ICrud
{
	
	private $accountTable = 'log_online_count';
	private $logcachedb = null;
	
	public function __construct()
	{
		parent::__construct();
		$this->webdb = $this->load->database('logcachedb', TRUE);
	}
	
	public function count($parameter = null, $extension = null)
	{
		if(!empty($parameter))
		{
			foreach($parameter as $key=>$value)
			{
				$this->webdb->where($key, $value);
			}
		}
		if(!empty($extension))
		{
			
		}
		return $this->webdb->count_all_results($this->accountTable);
	}
	
	public function create($row)
	{
		if(!empty($row))
		{
			if($this->webdb->insert($this->accountTable, $row))
			{
				return $this->webdb->insert_id();
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	public function read($parameter = null, $extension = null, $limit = 0, $offset = 0)
	{
		if(!empty($parameter))
		{
			foreach($parameter as $key=>$value)
			{
				$this->webdb->where($key, $value);
			}
		}
		if(!empty($extension))
		{
			if(!empty($extension['select']) && is_array($extension['select']))
			{
				$this->webdb->select($extension['select']);
			}
			if(!empty($extension['group_by']))
			{
				$this->webdb->group_by($extension['group_by'][0], $extension['group_by'][1]);
			}
			if(!empty($extension['order_by']))
			{
				$this->webdb->order_by($extension['order_by'][0], $extension['order_by'][1]);
			}
		}
		if($limit==0 && $offset==0) {
			$query = $this->webdb->get($this->accountTable);
		} else {
			$query = $this->webdb->get($this->accountTable, $limit, $offset);
		}
		if($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function update($id, $row)
	{
		if(!empty($id) && is_array($id) && !empty($row))
		{
			$this->webdb->where('server_id', $id['server_id']);
			$this->webdb->where('log_date', $id['log_date']);
			$this->webdb->where('log_hour', $id['log_hour']);
			return $this->webdb->update($this->accountTable, $row);
		}
		else
		{
			return false;
		}
	}
	
	public function delete($id)
	{
		if(!empty($id) && is_array($id))
		{
			$this->webdb->where('server_id', $id['server_id']);
			$this->webdb->where('log_date', $id['log_date']);
			$this->webdb->where('log_hour', $id['log_hour']);
			return $this->webdb->delete($this->accountTable);
		}
		else
		{
			return false;
		}
	}
}

?>