<?php

include('config.php');
include('mainClass.php');
$mainClass = new mainClass();

if ( $_SERVER['REQUEST_METHOD'] === 'GET'  || $_SESSION['role']!='admin' ) 
{
	echo "notworking";
    http_response_code($badRequest);
}



else
{
	$db = getDB();
	$params = array();
	$params=$_POST;
	$user=$params['user'];
	$addr=$params['addr'];
	echo "sadsad";
	echo $user;
	$stmt = $db->prepare( "SELECT * from users where name like '$user' ");
	$stmt->execute();
	echo "sadsad2321321";
	$i=$stmt->fetchAll(PDO::FETCH_ASSOC);
	echo "trythis";
	echo $i;
	$p=$i[0]['id'];
	echo $p;
	$stmt = $db->prepare( "INSERT INTO ip_addr VALUES ('','$user','$addr','$p') ");
	$stmt->execute();
				
	http_response_code($success);
}
?>
