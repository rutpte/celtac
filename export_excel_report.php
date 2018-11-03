<?php

//echo "ยังไม่เสร็จเลยครับ";exit;
/**
 * PHPExcel
 *
 * Copyright (c) 2006 - 2015 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2015 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    ##VERSION##, ##DATE##
 */
 

 
	require dirname(__FILE__) . '/includes/init.inc.php';
	
	 $str_date_start      	= isset($_GET['str_date_start']) ? $_GET['str_date_start'] : '';
	 $str_date_end       	= isset($_GET['str_date_end']) ? $_GET['str_date_end'] : '';
	 //var_dump($_SESSION['email']); exit;
	 
	if (isset($_SESSION['email'])) {//email,is_staff
		$obj 	= new Order($pdo);
		$rs_arr = $obj->getOrderExportReport($str_date_start, $str_date_end);
		$data = $rs_arr;
		//-----------------------------
		// echo '<pre>';
		// foreach($data as $key => $value)
		// {
			// var_dump($value);continue;
			// if (is_array($value) || is_object($value))
			// {
				// foreach ($value as $val)
				// {
					// echo 'xxx ; ';
					// var_dump($val);continue;
				// }
			// }

		// }
		// exit;
		//---------------------------------------------
		/*
		echo '<pre>';
		foreach($data as $key => $value)
		{
			//echo $key;
			// if($key == "success"){
				// echo $key.' ont in';
				// echo'<br>';
				// continue;
			// }
			//--
			if (is_array($value) || is_object($value))
			{
				foreach ($value as $val)
				{
					echo $key;
					//var_dump($val);
				}
			}
			
		}
		exit;
		*/
		//---------------------------------------------
		//echo '<pre>';
		//var_dump($rs_arr["cell"]);
		
		// if($rs_arr["cell"]){
			// echo 'true';
		// }else{
			// echo 'false';
		// }
		// exit;
		//var_dump($rs_arr["prfm_tuee"]); exit;
		// if($rs_arr['success']){
			// if($rs_arr["prfm_tuee"] != false){
				// $data['prfm_tuee'] = $rs_arr["prfm_tuee"];
			// }
			
		// } else {
			// echo 'false.....';
		// }
		//----> debug.
		
		//echo '<pre> ';
		//var_dump($data);exit;
		
		// foreach($data as $key => $value)
		// {
			// var_dump($value);
		// }
		// exit;
		//------
		
	} else {
		header("Location: http://" . $_SERVER['HTTP_HOST'] ."/".PROJ_NAME. "/index.php");
	} 
	//-------------------------------------------------

	
	set_time_limit(0);
	//header('Content-Type: text/html; charset=UTF-8');
	date_default_timezone_set('Asia/Bangkok');

	/** Include PHPExcel */
	require_once 'libs/PHPExcel/Classes/PHPExcel.php';


	$arr_col_cell = array(

		"customer_name" 	=> "customer_name"
		,"quantity" 		=> "quantity"
		,"total_cell" 		=> "total_cell"
		,"staff_n" 			=> "staff_n"
		,"dealer_company" 	=> "dealer_company"
		,"price_rate" 		=> "price_rate"
	);
	$arr_col_else = array(

		"customer_name" 	=> "customer_name"
		,"quantity" 		=> "quantity"
		,"set" 				=> "set"
		,"vial" 			=> "vial"
		,"staff_n" 			=> "staff_n"
		,"dealer_company" 	=> "dealer_company"
		,"price_rate" 		=> "price_rate"
	);
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getDefaultStyle()->getFont()->setName('Cordia New')->setSize(13);
	$objPHPExcel->getProperties()->setTitle("order cell")->setDescription($daliv_date.' '.$daliv_time);
	$objPHPExcel->removeSheetByIndex(0);//and then crate it below.
	$i = 0;

			
	$objPHPExcel->createSheet($i);
	$objPHPExcel->setActiveSheetIndex($i);
	$objPHPExcel->getActiveSheet()->setTitle("order cell");

	$objPHPExcel->getActiveSheet()->mergeCells('A1:G1')->getStyle('A1:G1')->getFont()->setSize(7)->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "order cell : ".$daliv_date." ".$daliv_time);
	
	//--------------------------------------------------------------------------------------------
	//echo '<pre>';
	//var_dump($data); exit;
	//--------------------------------------------------------------------------------------------
	//--> add data.
	
	$row_data = 3;
	foreach($data as $key => $value)
	{
		
		if($key == "success"){
			continue;
		}
		//---
		$col = 0;
		$row_data = $row_data+2;
		$rowofcol = $row_data;
		
		//--> add column.-------------------------------------------------------------------------------
		echo "</br>";
		if($key == "cell"){
			$arr_col = $arr_col_cell;
		} else {
			$arr_col = $arr_col_else;
		}
		foreach ($arr_col as  $key => $value_col) 
		{
			//echo "column : ".$col." : ". $rowofcol." : ". $value_col;
			echo $value_col;
			echo ' -> '.$col.':'. $rowofcol;
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $rowofcol, $value_col);
			$col++;
		}
		echo "</br>";
		//------------------------------------------------------------------------------------------------
		//$obj_date 		= new DateTime($value['delivery_date_time']);;
		//$daliv_date 	= $obj_date->format('d-m-Y');
		//$daliv_time 	= $obj_date->format('H:i:s');
		//------------------------------------------
		//var_dump($value['order_code']);

			
		//------------------------------------------------------------------------------------------------
		//--> add data row.
		$col = 0;
		$row_data++;
		if (is_array($value) || is_object($value))
		{
			foreach ($value as $each_val) 
			{
				$pre_staff_n = '';
				if($pre_staff_n != ''){
					
					if($each_val['staff_n'] == $pre_staff_n){
						if(($index_color%2)==0){
							$color = 'fcfcfc';
						} else {
							$color = 'c6c6c6';
						}
						$pre_staff_n = $each_val['staff_n'];
					}else{
						$index_color++;
						if($color == 'c6c6c6'){
							$color = 'fcfcfc';
						} else {
							$color = 'c6c6c6';
						}
						$pre_staff_n = $each_val['staff_n'];
					}
				} else {
					//--> init_config.
					$color = 'fcfcfc';
					$pre_staff_n = $each_val['staff_n'];
				}
				//----
				
				foreach ($arr_col as  $key => $value) 
				{

					$rs_data = $each_val[$key];
					echo "".$rs_data.",";
					echo $col.$row_data;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row_data, $rs_data);
					$columnLetter = PHPExcel_Cell::stringFromColumnIndex($col);
					
					cellColor($columnLetter.$row_data,$color);
					$col++;
				}
				echo '</br>';

				$row_data++;
				echo 'on value : '.$row_data;
			}

		}

	}

	//--------------------------------------------------------------------------------------------
	//--> set auto width.
	$sheet = $objPHPExcel->getActiveSheet();
    $cellIterator = $sheet->getRowIterator()->current()->getCellIterator();
    $cellIterator->setIterateOnlyExistingCells(true);
    /** @var PHPExcel_Cell $cell */
    foreach ($cellIterator as $cell) {
        $sheet->getColumnDimension($cell->getColumn())->setAutoSize(true);
    }
	//--------------------------------------------------------------------------------------------
	//--> set color.
	//cellColor('A2:G2', 'adad85');
	//--------------------------------------------------------------------------------------------
	function cellColor($cells,$color){
		global $objPHPExcel;

		$objPHPExcel->getActiveSheet()->getStyle($cells)->applyFromArray(array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			)
		));
		//--
		$objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'startcolor' => array(
				 'rgb' => $color
			)
		));		
		//--------------------------------------------------
		/*
		$objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'startcolor' => array(
				 'rgb' => $color
			)
			,'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			)
		));
		*/
	}
	
	//--------------------------------------------------------------------------------------------
	//--> set center.
	//$objPHPExcel->getActiveSheet()->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	//$objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	//---
    // $style = array(
        // 'alignment' => array(
            // 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        // )
    // );

    // $sheet->getDefaultStyle()->applyFromArray($style);
	//--------------------------------------------------------------------------------------------
	exit;
	$file_name = "order";
	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
	header('Cache-Control: max-age=0');
	// If you're serving to IE 9, then the following may be needed
	header('Cache-Control: max-age=1');

	// If you're serving to IE over SSL, then the following may be needed
	header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0
	//--------------------------------------------------------------------------------------------
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	//$objWriter->save('./excel_output/order_cell.xls');
	$objWriter->save('php://output');

	
//$objWriter->save('./outputExcel/server/'.$pro_name.'/'.$file_name.'.xls');

exit;