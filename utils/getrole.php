 <?php
 	include('config.php');
 	 header("Access-Control-Allow-Origin: *");
	 if(isset($_SESSION['role']))
	 {
	    echo json_encode($_SESSION['role']);
	    http_response_code($success);
	 }
	 else
	 {
	 	echo json_encode('-1');
	 }

		
?>
