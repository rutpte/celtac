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
	if (isset($_SESSION['email'])) {
		$obj 	= new Order($pdo);
		$rs_arr = $obj->getOrderAll();
		$data = array();
	
		if($rs_arr['success']){
			$data = $rs_arr['data'];
		}
		// foreach($data as $key => $value)
		// {
			// var_dump($value['order_code']);
		// }
		// exit;
		
	} else {
		header("Location: http://" . $_SERVER['HTTP_HOST'] ."/".PROJ_NAME. "/index.php");
	} 
	//-------------------------------------------------
	$obj_date 		= new DateTime($value['delivery_date_time']);;
	$daliv_date 	= $obj_date->format('d-m-Y');
	$daliv_time 	= $obj_date->format('H:i:s');
	
	set_time_limit(0);
	//header('Content-Type: text/html; charset=UTF-8');
	date_default_timezone_set('Asia/Bangkok');

	/** Include PHPExcel */
	require_once 'libs/PHPExcel/Classes/PHPExcel.php';


	$arr_col = array(
		"order_code"
		,"customer_name"
		,"product_type"
		,"quantity"
		,"vial"
		,"total_cel"
		,"package_type"
		,"delivery_date_time"
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

	$objPHPExcel->getActiveSheet()->mergeCells('A1:O1')->getStyle('A1:O1')->getFont()->setSize(15)->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('A1:O1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "order cell : ".$daliv_date." ".$daliv_time);
	
	//--------------------------------------------------------------------------------------------
	$col = 0;
	$rowofcol = 2;
	
	//--> add column.
	foreach ($arr_col as &$value) 
	{
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $rowofcol, $value);
		$col++;
	}
	//--------------------------------------------------------------------------------------------
	//echo '<pre>';
	//var_dump($data); exit;
	//--------------------------------------------------------------------------------------------
	//--> add data.
	$row_data = 3;
	foreach($data as $key => $value)
	{
		//var_dump($value['order_code']);
		$col = 0;
		foreach ($arr_col as &$key) 
		{
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row_data, $value[$key]);
			$col++;
		}

		$row_data++;
	}

	//--------------------------------------------------------------------------------------------


	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('./excel_output/order_cell.xls');

	
//$objWriter->save('./outputExcel/server/'.$pro_name.'/'.$file_name.'.xls');
echo 'export successfully .<br />'."\n";