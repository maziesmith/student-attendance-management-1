<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('config.php');
include('mainClass.php');
$mainClass = new mainClass();
//print_r($_SESSION);


// if ( $_SERVER['REQUEST_METHOD'] === 'GET' ) 
// {
//     http_response_code($badRequest);
// }

$db = getDB();

$a=573;
$month = 7;
$year = 2018;
$str = "SELECT * from students where rollno = '2013IPG-115'";
$query = "SELECT COUNT(*) as total, SUM(sanctioned) sanctioned, SUM(contingency) cl, SUM(medical) ml, SUM(maternity) maternity, SUM(duty) duty , SUM(work_off) work_off  FROM attendance WHERE student_id = :student_id AND month >= :month AND year = :year GROUP BY student_id"; 
$stmt = $db->prepare($query);
$stmt->bindParam("student_id",$a,PDO::PARAM_STR);
$stmt->bindParam("month", $month,PDO::PARAM_STR);
$stmt->bindParam("year", $year,PDO::PARAM_STR);
$stmt->execute();

$previous_count=$stmt->fetchAll(PDO::FETCH_OBJ);
$previous_count = $previous_count[0];
var_dump($previous_count);

//echo $str;
// $stmt=$db->prepare($str);
// $stmt->execute();
// $dates=$stmt->fetchAll(PDO::FETCH_ASSOC);
// $d=date('d');
// $m=date('m');
// $y=date('Y');
// $date_current=$d.'-'.$m.'-'.$y;
// //echo strtotime("14-04-2016");
// $intern_start_date = $dates[0]['intern_start_day'].'-'.$dates[0]['intern_start_month'].'-'.$dates[0]['intern_start_year'];
// if($dates[0]['intern_end_day']!=NULL)
//     $intern_end_date = $dates[0]['intern_end_day'].'-'.$dates[0]['intern_end_month'].'-'.$dates[0]['intern_end_year'];
// else 
//     $intern_end_date=$date_current;
// if(strtotime($date_current)>=strtotime($intern_start_date)&&strtotime($date_current)<=strtotime($intern_end_date))
// {
    
//     $data=1;
// }
// else
// {
//     $data=2;
// }
// echo $data;
// echo strtotime($date_current).'\n';
// echo strtotime($intern_start_date).'\n';
// echo strtotime($intern_end_date).'\n';
// echo json_encode($data);
  //  $oneDimensionalArray = array_map('current', $data4);
   // print_r($oneDimensionalArray);
   // echo $data4[array_search(553,$oneDimensionalArray)]['amount'];
    