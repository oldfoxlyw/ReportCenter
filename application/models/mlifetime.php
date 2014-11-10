<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('ICrud.php');

class Mlifetime extends CI_Model implements ICrud
{
	
	private $accountTable = 'log_market_lifetime';
	private $logcachedb = null;
	
	public function __construct()
	{
		parent::__construct();
		$this->logcachedb = $this->load->database('logcachedb', TRUE);
	}
	
	public function count($parameter = null, $extension = null)
	{
		if(!empty($parameter))
		{
			foreach($parameter as $key=>$value)
			{
				$this->logcachedb->where($key, $value);
			}
		}
		if(!empty($extension))
		{
			
		}
		return $this->logcachedb->count_all_results($this->accountTable);
	}
	
	public function create($row)
	{
		if(!empty($row))
		{
			if($this->logcachedb->insert($this->accountTable, $row))
			{
				return $this->logcachedb->insert_id();
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
				$this->logcachedb->where($key, $value);
			}
		}
		if(!empty($extension))
		{

		}
		if($limit==0 && $offset==0) {
			$query = $this->logcachedb->get($this->accountTable);
		} else {
			$query = $this->logcachedb->get($this->accountTable, $limit, $offset);
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
			$this->logcachedb->where('date', $id['date']);
			$this->logcachedb->where('server_id', $id['server_id']);
			$this->logcachedb->where('partner_key', $id['partner_key']);
			return $this->logcachedb->update($this->accountTable, $row);
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
			$this->logcachedb->where('date', $id['date']);
			$this->logcachedb->where('server_id', $id['server_id']);
			$this->logcachedb->where('partner_key', $id['partner_key']);
			return $this->logcachedb->delete($this->accountTable);
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
			$query = $this->logcachedb->query($sql);
			if($query->num_rows() > 0)
			{
				return $query->result();
			}
		}
		return false;
	}
}

?>