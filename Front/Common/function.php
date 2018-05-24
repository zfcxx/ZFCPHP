<?php

/*excel文件生成数组*/
function ArrExcel($filePath){
	define('SYSPATH_LOCALHOST',SYSPATH_LOCALHOST.'/Common/PHPExcel_1.8/');//
    require_once SYSPATH_LOCALHOST.'/Common/PHPExcel_1.8/PHPExcel.php';
    require_once SYSPATH_LOCALHOST.'/Common/PHPExcel_1.8/PHPExcel/Writer/Excel2007.php'; // 用于 excel-2007 格式
    require_once SYSPATH_LOCALHOST.'/Common/PHPExcel_1.8/PHPExcel/Writer/Excel5.php'; // 用于 excel-2007 格式

    $PHPExcel = new PHPExcel(); 
    $PHPReader = new PHPExcel_Reader_Excel2007(); 
     if(!$PHPReader->canRead($filePath)){ 
    $PHPReader = new PHPExcel_Reader_Excel5(); 
        if(!$PHPReader->canRead($filePath)){ 
            echo 'no Excel'; 
            return ; 
            } 
    } 

    $PHPExcel = $PHPReader->load($filePath); // 载入excel文件
    $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
    $highestRow = $sheet->getHighestRow(); // 取得总行数
    $highestColumm = $sheet->getHighestColumn(); // 取得总列数
    $highestColumm= PHPExcel_Cell::columnIndexFromString($highestColumm); //字母列转换为数字列 如:AA变为27
     $arr=[];
     $data=[];
    /** 循环读取每个单元格的数据 */
    for ($row = 1; $row <= $highestRow; $row++){//行数是以第1行开始
        for ($column = 0; $column < $highestColumm; $column++) {//列数是以第0列开始
            if($row ==1){
                $columnName = PHPExcel_Cell::stringFromColumnIndex($column);
                $arr[$columnName]=(string)$sheet->getCellByColumnAndRow($column, $row)->getValue();
            }else{
                $columnName = PHPExcel_Cell::stringFromColumnIndex($column);
                $data[$row-1][$arr[$columnName]]=(string)$sheet->getCellByColumnAndRow($column, $row)->getValue();
            }
            // $columnName = PHPExcel_Cell::stringFromColumnIndex($column);
            // echo $columnName.$row.":".$sheet->getCellByColumnAndRow($column, $row)->getValue()."<br />";
        }
    }
    return $data;
} 

//excel修改 支持英文
//$templateName 地址
//$outputFileName  输出文件名
//$text 内容
//$wz 位置  
//$flie
function ExcelEdit($templateName='sndemo.xlsx',$outputFileName='zfc',$wz='I3',$txt='zff'){
	define('SYSPATH_LOCALHOST',SYSPATH_LOCALHOST.'/Common/PHPExcel_1.8/');//
    require_once SYSPATH_LOCALHOST.'/Common/PHPExcel_1.8/PHPExcel.php';
    require_once SYSPATH_LOCALHOST.'/Common/PHPExcel_1.8/PHPExcel/Writer/Excel2007.php'; // 用于 excel-2007 格式
    require_once SYSPATH_LOCALHOST.'/Common/PHPExcel_1.8/PHPExcel/Writer/Excel5.php'; // 用于 excel-2007 格式

    //实例化Excel读取类
    $PHPReader = new PHPExcel_Reader_Excel2007();
    if(!$PHPReader->canRead($templateName)){
     $PHPReader = new PHPExcel_Reader_Excel5();
     if(!$PHPReader->canRead($templateName)){
      echo '无法识别的Excel文件！';
      return false;
     }
    }
    //读取Excel
    $PHPExcel = $PHPReader->load($templateName);
    //读取工作表1
    $currentSheet = $PHPExcel->getSheet(0);

    $currentSheet->setCellValue($wz,iconv('gbk','utf-8',$txt));//表头赋值//
    //实例化Excel写入类
    $PHPWriter = new PHPExcel_Writer_Excel2007($PHPExcel);
    // $PHPWriter = new  PHPExcel_Writer_Excel5($PHPExcel);
    header("Content-Type: application/vnd.ms-excel; charset=utf-8"); 
    header("Pragma: public"); 
    header("Expires: 0"); 
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
    header("Content-Type: application/force-download"); 
    header("Content-Type: application/octet-stream"); 
    header("Content-Type: application/download"); 
    header("Content-Disposition: attachment;filename={$outputFileName}".date("YmdHis").".xlsx"); 
    header("Content-Transfer-Encoding: binary ");
    // $objWriter = PHPExcel_IOFactory::createWriter($objExcel, 'Excel5');

    $PHPWriter->save('php://output');
}

//重新等于数组值
// function myfunction($v)
// {
//   return($v*$v);
// }

// $a=array(1,2,3,4,5);
// print_r(array_map("myfunction",$a))

?>