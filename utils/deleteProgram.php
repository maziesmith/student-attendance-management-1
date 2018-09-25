<?php

include('config.php');
include('mainClass.php');
$mainClass = new mainClass();

if ( $_SERVER['REQUEST_METHOD'] === 'GET' || $_SESSION['role']!='admin') 
{
    http_response_code($badRequest);
}



else
{
	$db = getDB();
	$params = array();
	$params=$_POST;
	$programName=$params['programName'];
	 
	$stmt = $db->prepare( "DELETE FROM program WHERE program_name = '$programName' ");
	$stmt->execute();
				
	http_response_code($success);
}
?>
