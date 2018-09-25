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
    //echo $roll;
    $db = getDB();
    $str = 'UPDATE students SET stipend_eligible = !stipend_eligible WHERE rollno ="'.$roll.'"';
    //echo $str;
    $stmt=$db->prepare($str);
    $stmt->execute();
    //echo $str;
//     $progid=$stmt->fetchAll(PDO::FETCH_ASSOC);
//   //  print_r($progid);
// 	$data = $progid[0]['stipend_eligible'];
// 	echo json_encode($data);
}
    

?>