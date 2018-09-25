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
    
    $db = getDB();
    $str = "SELECT * FROM deduction_types WHERE 1";
   // $db->prepare($str);
    $stmt=$db->prepare($str);
    $stmt->execute();
    //echo $str;
    $progid=$stmt->fetchAll(PDO::FETCH_ASSOC);
  //  print_r($progid);
    $data = $progid;
   // var_dump($progid);
	echo json_encode($data);
}