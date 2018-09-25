<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('config.php');
include('mainClass.php');
$mainClass = new mainClass();


if ( $_SERVER['REQUEST_METHOD'] === 'GET' ) 
{
    http_response_code($badRequest);
}



else
{
    $roll = $_POST['roll'];
    $db = getDB();
    $str = "SELECT * from students where rollno = '$roll'";
    //echo $str;
    $stmt=$db->prepare($str);
    $stmt->execute();
    $dates=$stmt->fetchAll(PDO::FETCH_ASSOC);
    $d=date('d');
    $m=date('m');
    $y=date('Y');
    $date_current=$d.'-'.$m.'-'.$y;
//echo strtotime("14-04-2016");
if($dates[0]['intern_start_day']==NULL){
    $intern_start_date='10-10-2099';
}
else{
    $intern_start_date = $dates[0]['intern_start_day'].'-'.$dates[0]['intern_start_month'].'-'.$dates[0]['intern_start_year'];
}
if($dates[0]['intern_end_day']!=NULL)
    $intern_end_date = $dates[0]['intern_end_day'].'-'.$dates[0]['intern_end_month'].'-'.$dates[0]['intern_end_year'];
else 
    $intern_end_date=$date_current;
if(strtotime($date_current)>=strtotime($intern_start_date)&&strtotime($date_current)<=strtotime($intern_end_date))
{   
    
    $data=1;
}
else
{
    $data=2;
}
	echo json_encode($data);
}
    

?>