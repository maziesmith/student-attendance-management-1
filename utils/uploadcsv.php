<?php
ini_set('display_errors',1);
		  	 		ini_set('display_startup_errors',1);
		  	 		error_reporting(E_ALL);
include('config.php');
include('mainClass.php');
$db = getDB();
		//echo '1';

if(true){
		//echo '2';
		
		
		//print_r($_FILES); 
		$filename=$_FILES["csvFile"]["tmp_name"];	
		//print_r($_POST);
		//print_r($_FILES);

 
 
		 if($_FILES["csvFile"]["size"] > 0)
		 {
		 	$file = fopen($filename, "r");
		 	for($i=0;$i<=4;$i++)
		 	{	
		     	$getData = fgetcsv($file, 10000, ",");
		     }
		     $month=$_POST["month"];
		     $year=$_POST["year"];


		    // $getData = fgetcsv($file, 10000, ",");
		     //echo $getData;
		     //echo '<br>';
		  	// $ar = explode(',',$getData);
		  	// print_r($ar);
		  	




			  $getData = fgetcsv($file, 10000, ",");
			 $flag=0;

	        while(!feof($file))
	         {
	         	
	         	 $t = $getData[2];
		  	//echo $t;
		  	 $stmt2 = $db->prepare("SELECT id,program_id FROM students WHERE rollno ='$t' ");
		  	 $stmt2->execute();
			 $data=$stmt2->fetchAll(PDO::FETCH_ASSOC);
			 if(!isset($data[0]['id']) || $data[0]['id']==0)
			 {	
				$getData = fgetcsv($file, 10000, ",");
				continue;
			 }
			 
			 
			 $stmt2 = $db->prepare("SELECT * FROM students WHERE rollno = '$t' ");
			 $stmt2->execute();
			 $data=$stmt2->fetchAll(PDO::FETCH_ASSOC);
			 $d=date('d');
			 $m=date('m');
			 $y=date('Y');
			 $date_current=$d.'-'.$m.'-'.$y;
			 //echo strtotime("14-04-2016");
			 if($data[0]['intern_start_day']==NULL){
				$intern_start_date='10-10-2099';
			 }
			 else{
			 $intern_start_date = $data[0]['intern_start_day'].'-'.$data[0]['intern_start_month'].'-'.$data[0]['intern_start_year'];
			 }
			 if($data[0]['intern_end_day']!=NULL)
				 $intern_end_date = $data[0]['intern_end_day'].'-'.$data[0]['intern_end_month'].'-'.$data[0]['intern_end_year'];
			 else 
				 $intern_end_date='10-10-2030';

			 $stmt2 = $db->prepare("SELECT stipend FROM program WHERE id = '".$data[0]['program_id']."' " );
		  	 $stmt2->execute();
			 $stip=$stmt2->fetchAll(PDO::FETCH_ASSOC);
			 $payable=$stip[0]['stipend'];
			 //print_r($data);

			// echo $data[0]['id'];
			// echo $data[0]['program_id'];
		  	// print_r($ar);

			 /*$str='';
			 $str .= $data[0]['id'].',';
			 $str .= $data[0]['program_id'].',';
			 $str .= $year.',';
			 $str .= $month.',';
			 $str .= $getData[5];
			 $str .= $getData[6];*/
 			$months = [31,28,31,30,31,30,31,31,30,31,30,31];
			if($year%4 ==0 && $year%100!=0)
				$months[1] == 29;

			$p=$months[$month-1]+3;
			$a=$p+1;
			//echo "$p:".$p;
			//echo "$a:".$a;
			$present_dates=[];
			$count=0;
			for($i=3;$i<$p;$i++){
				$checkingdate = ($i-2)."-".$month."-".$year;
				// echo $checkingdate.'\n';
				// echo $intern_end_date.'\n';
				// echo $intern_start_date.'\n';
				if(strtotime($checkingdate)>=strtotime($intern_start_date)&&strtotime($checkingdate)<=strtotime($intern_end_date))
				{
					if($getData[$i]=='P'){
						$count++;
					}
					$getData[$i]='A';
				}
				//echo $getData[$i];
				if($getData[$i]=="P"){
					$s=($i-2)."/".$month."/".$year;
					array_push($present_dates, $s);
				}
			}
			$getData[$p]=$getData[$p]-$count;
			$getData[$a]=$getData[$a]+$count;

 		$payable=$getData[$p]*($payable/$months[$month-1]);
	           $sql = "INSERT into attendance (student_id,program_id,year,month,present,absent,sanctioned,medical,contingency,maternity,duty,work_off,payable,form_submitted) 
                   values ('".$data[0]['id']."','".$data[0]['program_id']."','$year','$month','".$getData[$p]."','".$getData[$a]."','0','0','0','0','0','0','$payable','0')";
                 //  echo $sql;
                $stmt2 = $db->prepare($sql);
		  	 $result=$stmt2->execute(); 
		  if(isset($result)){
		for($i=0;$i<sizeof($present_dates);$i++){
			$d=$present_dates[$i];
		$sql = "INSERT into dateattendance (student_id,dates,type)values ('".$data[0]['id']."','$d','P')";
                //echo "presents".$d." ";
                $stmt3 = $db->prepare($sql);
		  	 $result2=$stmt3->execute(); 
		  	}
		  }
				
				if(isset($result) )
				{
						
				}
				else {
					  $flag=1;
				}
				//break;
				$getData = fgetcsv($file, 10000, ",");
	         }
			 if($flag==0){
				 echo "successfully uploaded the csv";
			 }
			 else{
				 echo "uploading failed.";
			 }
				
	         fclose($file);	
		 }
	}	 
 
 
 ?>