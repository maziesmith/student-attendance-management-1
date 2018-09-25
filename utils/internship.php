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
    $month = $_POST['month'];
    $year = $_POST['year'];
    $day = $_POST['day'];
    $but = $_POST['but'];
    $db = getDB();
    if($but=='STOP SCHOLARSHIP')

        $str = "UPDATE students set intern_start_day ='$day' ,intern_start_month = '$month',intern_start_year = '$year', intern_end_day = NULL,intern_end_month = NULL,intern_end_year = NULL where rollno = '$roll' ";
   
    else if($but=='START SCHOLARSHIP')
        $str = "UPDATE students set intern_end_day = '$day',intern_end_month = '$month',intern_end_year = '$year' where rollno = '$roll' ";
    
        //echo $str;
    // $this->pdo->setAttribute(PDO:: ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    //$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $stmt=$db->prepare($str);
    $result=$stmt->execute();
    $arr['error'] = $stmt->errorCode();
    $arr['message'] = $result;
	echo json_encode($arr);
}
    

?>