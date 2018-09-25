<?php 
	include("config.php");
	include('mainClass.php');
	error_reporting(-1);
ini_set('display_errors', 'On');
	$mainClass = new mainClass();
	print_r($_REQUEST);
	function getRealIpAddr()
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
		{
		$ip=$_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
		{
		$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else
		{
		$ip=$_SERVER['REMOTE_ADDR'];
		}
		//////echo '<script>alert($ip);</script>';
		return $ip;
	}

	if ( $_SERVER['REQUEST_METHOD'] === 'GET'  || !isset($_POST['password']) || empty($_POST['password']) || !isset($_POST['email']) || empty($_POST['email']) ) 
	{
		//echo 0;
		http_response_code($badRequest);
	}
	// else
	// {
	// 	//echo ("<script>alert('".getRealIpAddr()."')</script>");
	// 	http_response_code($badRequest);
	// }

	else
	{
		
		$email=$_POST['email'];
		$password=$_POST['password'];
		//$ip = 

		if(strlen(trim($email))>1 && strlen(trim($password))>1 )
		{
			//echo ("<script>alert('".getRealIpAddr()."')</script>");
			$uid = $mainClass->userLogin($email,$password,getRealIpAddr());
			//$uid = 0;
		    if($uid)
		    {
				
		        http_response_code($success); 
		    }
		}

	}


?>
