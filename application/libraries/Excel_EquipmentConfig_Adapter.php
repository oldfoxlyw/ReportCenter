<?php

class Excel_EquipmentConfig_Adapter {
	public function ParseExcel($file)
	{
		set_include_path(get_include_path() . PATH_SEPARATOR . BASEPATH . 'libraries/excel');
	
		require_once 'PHPExcel.php';
		require_once 'PHPExcel/IOFactory.php';
		require_once 'PHPExcel/Reader\Excel5.php';

		$result = array();
		if(!empty($file)) //如果上传文件成功，就执行导入excel操作
		{
			$objReader = PHPExcel_IOFactory::createReader('Excel5');//use excel2007 for 2007 format
			$objPHPExcel = $objReader->load($file);
			$sheet = $objPHPExcel->getSheet(0);
			$highestRow = $sheet->getHighestRow(); // 取得总行数
			$highestColumn = $sheet->getHighestColumn(); // 取得总列数
			
			for($j=2; $j<=$highestRow; $j++)
			{
				$id = $objPHPExcel->getActiveSheet()->getCell("A$j")->getValue();
				$type = substr($id, strlen($id) - 1, 1);
				$preName = $objPHPExcel->getActiveSheet()->getCell("B$j")->getValue();
				$name = substr($preName, strlen($preName)-1, 1);
				if($name == '#')
				{
					$name = substr($preName, 0, strlen($preName)-1);
				}
				else
				{
					$name = $preName;
				}
				
				$row = array(
					'id'				=>	$id,
					'name'				=>	explode('#', $name),
					'type'				=>	$type
				);
				array_push($result, $row);
			}
			unlink($file);
		}
		return $result;
	}
	
	public function RemoveNull($array)
	{
		for($i=0; $i<count($array); $i++)
		{
			foreach($array[$i] as $key=>$value)
			{
				if(empty($value))
				{
					$array[$i][$key] = '';
				}
			}
		}
		return $array;
	}
}

?>