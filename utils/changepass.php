<?php 
	include("config.php");
	include('mainClass.php');
	$mainClass = new mainClass();

	if ( $_SERVER['REQUEST_METHOD'] === 'GET'  || !isset($_POST['oldpass']) || empty($_POST['newpass'])) 
	{
		http_response_code($badRequest);
	}

	else
	{
		$password=$_POST['oldpass'];
		$newpass=$_POST['newpass'];
		$email=$_SESSION['email'];


		try{

			$db = getDB();
			$hash_password =md5($password);
			$stmt = $db->prepare("SELECT * FROM users WHERE email=:email AND  password=:password");
			$stmt->bindParam("email", $email,PDO::PARAM_STR) ;
			$stmt->bindParam("password", $hash_password,PDO::PARAM_STR) ;
			$stmt->execute();
			$count=$stmt->rowCount();
			$data=$stmt->fetch(PDO::FETCH_OBJ);

			if($count==1)
			{
				$newpass=md5($newpass);
				$stmt2 = $db->prepare("UPDATE users SET password='$newpass' WHERE email=:email AND  password=:password");
				$stmt2->bindParam("email", $email,PDO::PARAM_STR);
				$stmt2->bindParam("password", $hash_password,PDO::PARAM_STR);
				$stmt2->execute();
				echo "yes";
			}
			else
			{
				http_response_code($GLOBALS['unauthorized']);
				return false;
			}
		}
		catch(PDOException $e) {
			echo $e->getMessage();
			http_response_code($GLOBALS['connection_error']);
		}
	}


?>
