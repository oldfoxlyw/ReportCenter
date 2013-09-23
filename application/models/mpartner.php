<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('ICrud.php');

class Mpartner extends CI_Model implements ICrud
{
	private $accountTable = 'scc_partner';
	private $webdb = null;
	
	public function __construct()
	{
		parent::__construct();
		$this->webdb = $this->load->database('webdb', TRUE);
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
			return $this->webdb->insert($this->accountTable, $row);
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
		if(!empty($id) && !empty($row))
		{
			$this->webdb->where('partner_key', $id);
			return $this->webdb->update($this->accountTable, $row);
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
			$this->webdb->where('partner_key', $id);
			return $this->webdb->delete($this->accountTable);
		}
		else
		{
			return false;
		}
	}
}

?>