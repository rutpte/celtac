<?php
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
	//$export_excel 	= in_array("export_order", $_SESSION['permissions']);
	if(true){
		$obj 	= new Order($pdo);
		$rs_arr = $obj->getOrderAll();
		$data = array();
	
		if($rs_arr['success']){
			$data = $rs_arr['data'];
		}
		
	} else {
		header("Location: http://" . $_SERVER['HTTP_HOST'] ."/".PROJ_NAME. "/index.php");
	} 
	//-------------------------------------------------

	
	set_time_limit(0);
	//header('Content-Type: text/html; charset=UTF-8');
	date_default_timezone_set('Asia/Bangkok');

	/** Include PHPExcel */
	require_once 'libs/PHPExcel/Classes/PHPExcel.php';


	$arr_col = array(
		"date"
		,"time"
		,"order_code"
		,"customer_name"
		,"product_type"
		,"quantity"
		,"vial"
		,"total_cell"
		,"package_type"
		,"giveaway"
		,"sender"
		,"receiver"
		,"dealer_person"
		,"dealer_company"
		,"user_id"
		,"order_date"
		,"last_update_date"
		,"price_rate"
		,"comment_else"
	);
		
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getDefaultStyle()->getFont()->setName('Cordia New')->setSize(13);
	$objPHPExcel->getProperties()->setTitle("order cell")->setDescription($daliv_date.' '.$daliv_time);
	$objPHPExcel->removeSheetByIndex(0);//and then crate it below.
	$i = 0;

			
	$objPHPExcel->createSheet($i);
	$objPHPExcel->setActiveSheetIndex($i);
	$objPHPExcel->getActiveSheet()->setTitle("order cell");

	//--> set head excel.
	$objPHPExcel->getActiveSheet()->mergeCells('A1:O1')->getStyle('A1:O1')->getFont()->setSize(15)->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('A1:O1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "order cell : ".$daliv_date." ".$daliv_time);
	
	//--------------------------------------------------------------------------------------------
	$col = 0;
	$rowofcol = 2;
	
	//--> add column.
	
	foreach ($arr_col as $valuex) 
	{
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $rowofcol, $valuex);
		$col++;
	}
	//--------------------------------------------------------------------------------------------
	//echo '<pre>';
	//var_dump($data); exit;
	//--------------------------------------------------------------------------------------------
	//--> add data.
	$pre_code = '';
	$row_data = 3; 
	foreach($data as $key => $value)
	{
		$obj_date 		= new DateTime($value['delivery_date_time']);;
		$daliv_date 	= $obj_date->format('d-m-Y');
		$daliv_time 	= $obj_date->format('H:i:s');
		//------------------------------------------
		//var_dump($daliv_date); exit;
			if($pre_code != ''){
				
				if($value['order_code'] == $pre_code){
					if(($index_color%2)==0){
						$color = 'fcfcfc';
					} else {
						$color = 'c6c6c6';
					}
					$pre_code = $value['order_code'];
				}else{
					$index_color++;
					if($color == 'c6c6c6'){
						$color = 'fcfcfc';
					} else {
						$color = 'c6c6c6';
					}
					$pre_code = $value['order_code'];
				}
			} else {
				//--> init_config.
				$color = 'fcfcfc';
				$pre_code = $value['order_code'];
			}
			//-----------
		$col = 0;
		foreach ($arr_col as $key) 
		{

			if($key == "date"){
				$rs_data = $daliv_date;
			} else if ($key == "time"){
				$rs_data = $daliv_time;
			} else {
				$rs_data = $value[$key];
			}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row_data, $rs_data);
			
			//--> setcolor and center.
			$columnLetter = PHPExcel_Cell::stringFromColumnIndex($col);
			cellColor($columnLetter.$row_data,$color);
			$objPHPExcel->getActiveSheet()->getStyle($row_data+':'+$col)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$col++;
		}

		$row_data++;
	}

	//--------------------------------------------------------------------------------------------
	//--> set auto width.
	
	$sheet = $objPHPExcel->getActiveSheet();
    $cellIterator = $sheet->getRowIterator()->current()->getCellIterator();
    $cellIterator->setIterateOnlyExistingCells(true);
    ///@var PHPExcel_Cell $cell
    foreach ($cellIterator as $cell) {
        $sheet->getColumnDimension($cell->getColumn())->setAutoSize(true);
    }
	
	//--------------------------------------------------------------------------------------------
	//--> set color.
	cellColor('A2:R2', 'adad85');
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
	}
	//--------------------------------------------------------------------------------------------
	//--> set center.
	//-- $objPHPExcel->getActiveSheet()->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	//$objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	//---
	//$style = array( 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
	//$sheet = $objPHPExcel->getActiveSheet();
	
   // $sheet->getDefaultStyle()->applyFromArray($style);
   
	//--------------------------------------------------------------------------------------------
	/*
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="'xxx'.xlsx"');
	header('Cache-Control: max-age=0');
	// If you're serving to IE 9, then the following may be needed
	header('Cache-Control: max-age=1');

	// If you're serving to IE over SSL, then the following may be needed
	header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0
	*/

	//--------------------------------------------------------------------------------------------
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');//Excel2007,Excel5
	try {
		$objWriter->save('./excel_output/order_cell.xls');
		echo "File successfully saved";
	} catch (Exception $e) {
		echo 'ERROR: ', $e->getMessage();
		die();
	}
