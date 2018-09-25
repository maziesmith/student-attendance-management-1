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
    $deduction = $_POST['deduction_type'];
    $month = $_POST['month'];
    $year = $_POST['year'];
    $amount = $_POST['amount'];
    print_r($_POST);
    //echo $roll;
    $db = getDB();
    $str = 'INSERT INTO deductions (`student_id`,`month`,`year`,`deduction_type`,`amount`) VALUES((SELECT id FROM students WHERE rollno= :roll),:month,:year, (SELECT id FROM deduction_types WHERE type = :deduction_types), :amount)';
    $stmt=$db->prepare($str);
    $stmt->bindParam("roll", $roll,PDO::PARAM_STR);
    $stmt->bindParam("month", $month,PDO::PARAM_STR);
    $stmt->bindParam("year", $year,PDO::PARAM_STR);
    $stmt->bindParam("amount", $amount,PDO::PARAM_STR);

    $stmt->bindParam("deduction_types", $deduction,PDO::PARAM_STR);




    //echo $str;
   
    $stmt->execute();
    //echo $str;
//     $progid=$stmt->fetchAll(PDO::FETCH_ASSOC);
//   //  print_r($progid);
// 	$data = $progid[0]['stipend_eligible'];
// 	echo json_encode($data);
}
    

?>