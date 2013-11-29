<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Import extends CI_Controller
{

	public function __construct()
	{
		parent::__construct ();
	}
	
	public function index()
	{
		$this->load->view('api/import');
	}
	
	public function equipment_config_submit()
	{
		$this->load->library('Excel_EquipmentConfig_Adapter');
		
		$uploadDir = $this->config->item('upload_dir');
		$error = "";
		$msg = "";
		$fileElementName = 'equipmentConfig';
		$el = $this->input->get('el', TRUE);
		if($el) {
			$fileElementName = $el;
		}
		
		$config['upload_path'] = $uploadDir;
		$config['allowed_types'] = 'xls|xlsx';
		$config['encrypt_name'] = TRUE;
		
		$this->load->library('upload', $config);
		if (!$this->upload->do_upload($fileElementName)) {
			$error = $this->upload->display_errors('<stronng>', '</stronng>');
		} else {
			$data = $this->upload->data();
			$fileName = $uploadDir . '/' . $data['file_name'];
		}
		
		if(!empty($fileName))
		{
			$result = $this->excel_equipmentconfig_adapter->ParseExcel($fileName);
			$result = $this->excel_equipmentconfig_adapter->RemoveNull($result);
			
			if(!empty($result))
			{
				$config = array();
				
				$logdb = $this->load->database('logdb', TRUE);
				$logdb->truncate('equipment_name');
				
				foreach($result as $row)
				{
					foreach($row['name'] as $name)
					{
						$parameter = array(
								'equipment_name'	=>	$name,
								'type'				=>	$row['type']
						);
						$logdb->insert('equipment_name', $parameter);
					}
				}
				exit('success');
			}
		}
	}
	
	public function mission_config_submit()
	{
		$this->load->library('Excel_MissionConfig_Adapter');
		
		$uploadDir = $this->config->item('upload_dir');
		$error = "";
		$msg = "";
		$fileElementName = 'missionConfig';
		$el = $this->input->get('el', TRUE);
		if($el) {
			$fileElementName = $el;
		}
		
		$config['upload_path'] = $uploadDir;
		$config['allowed_types'] = 'xls|xlsx';
		$config['encrypt_name'] = TRUE;
		
		$this->load->library('upload', $config);
		if (!$this->upload->do_upload($fileElementName)) {
			$error = $this->upload->display_errors('<stronng>', '</stronng>');
		} else {
			$data = $this->upload->data();
			$fileName = $uploadDir . '/' . $data['file_name'];
		}
		
		if(!empty($fileName))
		{
			$result = $this->excel_missionconfig_adapter->ParseExcel($fileName);
			$result = $this->excel_missionconfig_adapter->RemoveNull($result);
			
			if(!empty($result))
			{
				$me = dirname(__FILE__);
				$configFile = str_replace('controllers\\api', '', $me) . 'config\\mission_config.php';
				$file = fopen($configFile);
				fwrite($file, $string);
			}
		}
	}
}

?>