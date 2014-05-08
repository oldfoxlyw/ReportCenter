<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('ICrud.php');

class Mconsume extends CI_Model implements ICrud
{
	
	private $accountTable = 'log_consume';
	private $logdb = null;
	
	public function __construct()
	{
		parent::__construct();
		$this->logdb = $this->load->database('logdb', TRUE);
	}
	
	public function count($parameter = null, $extension = null)
	{
		if(!empty($parameter))
		{
			foreach($parameter as $key=>$value)
			{
				$this->logdb->where($key, $value);
			}
		}
		if(!empty($extension))
		{
			
		}
		return $this->logdb->count_all_results($this->accountTable);
	}
	
	public function create($row)
	{
		if(!empty($row))
		{
			if($this->logdb->insert($this->accountTable, $row))
			{
				return $this->logdb->insert_id();
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
				$this->logdb->where($key, $value);
			}
		}
		if(!empty($extension))
		{
			if(!empty($extension['select']) && is_array($extension['select']))
			{
				$this->logdb->select($extension['select']);
			}
			if(!empty($extension['group_by']))
			{
				$this->logdb->group_by($extension['group_by'][0], $extension['group_by'][1]);
			}
			if(!empty($extension['order_by']))
			{
				$this->logdb->order_by($extension['order_by'][0], $extension['order_by'][1]);
			}
		}
		if($limit==0 && $offset==0) {
			$query = $this->logdb->get($this->accountTable);
		} else {
			$query = $this->logdb->get($this->accountTable, $limit, $offset);
		}
		if($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function update($id, $row)
	{
		if(!empty($id) && !empty($row))
		{
			$this->logdb->where('log_id', $id);
			return $this->logdb->update($this->accountTable, $row);
		}
		else
		{
			return false;
		}
	}
	
	public function delete($id)
	{
		if(!empty($id))
		{
			$this->logdb->where('log_id', $id);
			return $this->logdb->delete($this->accountTable);
		}
		else
		{
			return false;
		}
	}
	
	public function query($sql)
	{
		if(!empty($sql))
		{
			$query = $this->logdb->query($sql);
			if($query->num_rows() > 0)
			{
				return $query->result();
			}
		}
		return false;
	}

	public function db()
	{
		return $this->logdb;
	}
}

?>