<?php

include('config.php');
include('mainClass.php');
$student_id='';
$program_name='';
$presents='';
$absents='';
$sl='';
$ml='';
$cl='';
$maternity='';
$duty='';
$month = '';
$year ='';
$month = '';
$year = '';
$processed_date='';
$mainClass = new mainClass();

if(false)
{

}
else
{
	//echo 10;
	$params = array();
	$params = $_REQUEST;
	

	/*$student_id=$params['student_id'];*/
	
	$program=$params['program'];
	$month=$params['month'];
	$year=$params['year'];
	$stype=$params['type'];
	$processed_date=$params['processed_date'];
	$GLOBALS['program'] = $program;
	$GLOBALS['month'] = $month;
	$GLOBALS['year'] = $year;
	$GLOBALS['type'] = $stype;
	$ptype = $params['ptype'] ;
	// if($params['ptype'] == "Processed Only")
	// $GLOBALS['ptype'] = 1;
	// else 
	// $GLOBALS['ptype'] =0;
}




require('../fpdf181/fpdf.php');
class PDF extends FPDF

{

function Header()
{
	$monthname=['','January','February','March','April','May','June','July','August','September','October','November','December'];

	$this->SetFont('Arial','',15);
		$this->Image('logo_mid.png',5,1,'PNG');
		$this->Cell(15);
		$this->Cell(0,0,"ABV-Indian Institute of Information Technology and Management, Gwalior",0,0,'C');
		$this->Ln(25);
		$this->SetFont('Arial','B',10);

		$this->Cell(0,0,"Program: ".$GLOBALS['program']." |  Month : ".$monthname[$GLOBALS['month']]." | Year : ".$GLOBALS['year'],0,0,'L');

	

	
		$this->Ln(10);
		// $to_be_printed ="ABV-IIITM/F&A/Reg./2014"; 
		// $this->Cell(0,0,$to_be_printed,0,0,'L');
		// $this->SetFont('Arial','',10);
		// $this->Ln(10);
		// $this->Cell(0,0,"From: Joint Registrar(A&A)",0,0,'L');
		// $this->Ln(10);

}

function Footer()
{
	$this->Ln(10);
	$this->SetFont('Arial','B',6.5);
	$this->Cell(0,0,"Legends:",0,0,'L');
	$this->Ln(5);
	$this->Cell(0,0,"P: Present | A: Absent | WO : Work Off | CL: Contingency Leaves | ML : Medical Leaves | SL: Sanctioned Leaves | CM : Current Month | TT : Total Taken | SCH: Total Days for Scholarship | Total SCH: Scholarship entitled | SCH Amt: Scholarship awarded ",0,0,'L');
	$this->Ln();
}
function FancyTable($header, $header2, $data,$data2,$data3,$data4,$oneDimensionalArray)
	{
		
		$this->SetFont('Arial','',6.5);
	//	$months=array('Jan',"Feb",'Mar','May','Apr','May','Jun','Jul','Aug','Sept',"Oct",'Nov','Dec');

	//	$month_ver = $months[$month].'-'.+$year%100;
		
//		$count=0;
$w = array(8, 18, 45, 6, 18,12,12,12,12,12,12,15,20,24,15,20);
		$w2 = array(8, 18,45, 6,6,6,6,6,6,6,6,6,6,6,6,12,12,15,20,24,15,20);
		
		// for($i=0;$i<count($header);$i++)
		// 	$this->Cell($w[$i],9,$header[$i],1,0,'C');
        // $this->Ln();
        // for($i=0;$i<count($header2);$i++)
		// 	$this->Cell($w2[$i],9,$header2[$i],1,0,'C');
		// $this->Ln();
		// $x=1;
		$months = [0,31,28,31,30,31,30,31,31,30,31,30,31];
		if($year%4 ==0 && $year%100!=0)
			$months[1] = 29;
		$dom=$months[$data3[0]['month']];
		$j=0;
		$sum_sch=0;
		$processed_students=0;
		foreach($data as $row)
		{
			
			$count++;
			if($count%25==1)
			{
				
				for($i=0;$i<count($header);$i++)
					$this->Cell($w[$i],9,$header[$i],1,0,'LR');
        		$this->Ln();
        		for($i=0;$i<count($header2);$i++)
					$this->Cell($w2[$i],9,$header2[$i],1,0,'LR');
				$this->Ln();
		
			}

			$this->Cell($w2[0],5,$count,'LRB');
			$this->Cell($w2[1],5,$row['rollno'],'LRB');
            $this->Cell($w2[2],5,$row['name'],'LRB');
			$this->Cell($w2[3],5,$dom,'LRB');
			$this->Cell($w2[4],5,$data3[$j]['present'],'LRB');
		//	$this->Cell($w2[4],5,$data3[$j]['present'],'LR');
		//	$this->Cell($w2[3],5,$dom,'LR');
		//	$this->Cell($w2[3],5,$dom,'LR');

        //    $this->Cell($w2[4],7,$row['cl'],'LR');
            $this->Cell($w2[5],5,$data3[$j]['absent'],'LRB');
            $this->Cell($w2[6],5,$data3[$j]['work_off'],'LRB');
            $this->Cell($w2[7],5,$data3[$j]['contingency'],'LRB');
            $this->Cell($w2[8],5,$row['cl'],'LRB');
            $this->Cell($w2[9],5,$data3[$j]['medical'],'LRB');
            $this->Cell($w2[10],5,$row['ml'],'LRB');
            $this->Cell($w2[11],5,$data3[$j]['sanctioned'],'LRB');
			$this->Cell($w2[12],5,$row['sl'],'LRB');
			if( ($data2[0]['program_name']=='Ph.D-New' || $data2[0]['program_name']=='Ph.D-Old' ) && $row['gender']==0){
			$this->Cell($w2[13],5,$data3[$j]['maternity'],'LRB');
			$this->Cell($w2[14],5,$row['maternity'],'LRB');
			}
			else
			{
				$this->Cell($w2[13],5,'NA','LRB');
				$this->Cell($w2[14],5,'NA','LRB');
			}
			
			$total = $data3[$j]['present']+$data3[$j]['work_off']+$data3[$j]['contingency']+$data3[$j]['medical']+$data3[$j]['sanctioned']+$data3[$j]['maternity']+$data3[$j]['duty'];
			
            $this->Cell($w2[15],5,$total,'LRB');
			$this->Cell($w2[16],5,$data2[0]['stipend'],'LRB');
			$amount = round(($data2[0]['stipend']/$dom)*$total);
			
		//	$sum_sch-= $data4[$j]['amount'];
		//$data4[array_search(553,$oneDimensionalArray)]['amount'];
			$amount =$amount- $data4[$j]['amount'];
			$sum_sch+=$amount;
			$this->Cell($w2[17],5,$data4[$j]['amount'],'LRB');

			$this->Cell($w2[18],5,$amount,'LRB');

			$this->Cell($w2[19],5,$data3[$j]['bank_ac_number'],'LRB');
			$form_process = ($data3[$j]['form_submitted']==1)?"YES":"NO";
			if($form_process=="YES")
			{
				$processed_students++;
			}
            $this->Cell($w2[20],5,$form_process,'LRB');
            $this->Cell($w2[21],5,$data3[$j]['processed_date'],'LRB');
			$this->Ln();
			
			
			
			
			$j++;
		}
		$this->Cell($w2[0],5,'','LRB');
		$this->Cell($w2[1],5,'','LRB');
		$this->Cell($w2[2],5,'','LRB');
		$this->Cell($w2[3],5,'','LRB');
		$this->Cell($w2[4],5,'','LRB');
		$this->Cell($w2[5],5,'','LRB');
		$this->Cell($w2[6],5,'','LRB');
		$this->Cell($w2[7],5,'','LRB');
		$this->Cell($w2[8],5,'','LRB');
		$this->Cell($w2[9],5,'','LRB');
		$this->Cell($w2[10],5,'','LRB');
		$this->Cell($w2[11],5,'','LRB');
		$this->Cell($w2[12],5,'','LRB');
		$this->Cell($w2[13],5,'','LRB');
		$this->Cell($w2[14],5,'','LRB');
		$this->Cell($w2[15],5,'','LRB');
		$this->Cell($w2[16],5,'','LRB');

		$this->Cell($w2[17],5,'TOTAL','LRB');
		$this->Cell($w2[18],5,number_format($sum_sch),'LRB');
		$this->Cell($w2[19],5,'','LRB');
		$this->Cell($w2[20],5,'','LRB');
		$this->Cell($w2[21],5,'','LRB');
		//$this->Cell(array_sum($w),0,'','T');
		$this->Ln(10);
		$this->SetFont('Arial','B',7.5);
		
		
		$this->Cell(0,0,"Total Students : ".$count."    |    Processed Students : ".$processed_students,0,0,'L');
		$this->Ln(10);
		$this->Cell(0,0,"Compiled By : Yogesh                           |                       Generated By : ".$_SESSION['name']."                            |                       Forwarded By : Pankaj K. Gupta                            |                  Approved By : Director ",0,0,'L');
		$this->Ln();
	}
//	if($GLOBALS['ptype'] == 0)

}
	$pdf = new PDF('L');
    $header = array('SN','Roll Number','Name','TD','Biometric','CL','ML','SL','Maternity','','','','','','','');
	$header2 = array('','','','','P','A','WO','CM','TT','CM','TT','CM','TT','CM','TT','SCH Days','Total SCH','Deductions','SCH Amt','ACCOUNT NO','Processed','Process Date');
	$db = getDB();
	
	
	// Cumulative leaves of individual students for all
   if($stype=='ALL')
   {
	if($ptype == "ALL")
	{
		$str = "SELECT students.name as name , students.gender as gender ,students.rollno as rollno , attendance.payable as payable, SUM(attendance.contingency) as cl , SUM(attendance.sanctioned) as sl , SUM(attendance.medical) as ml , SUM(attendance.maternity) as maternity , SUM(attendance.duty) as duty , SUM(attendance.work_off) as wo  FROM attendance LEFT JOIN students on attendance.student_id = students.id WHERE attendance.month =".$month." AND attendance.year =".$year." AND students.program_name=:program GROUP BY students.id ";
	}  
	else
	{
		$str = "SELECT students.name as name , students.gender as gender ,students.rollno as rollno , attendance.payable as payable, SUM(attendance.contingency) as cl , SUM(attendance.sanctioned) as sl , SUM(attendance.medical) as ml , SUM(attendance.maternity) as maternity , SUM(attendance.duty) as duty , SUM(attendance.work_off) as wo  FROM attendance LEFT JOIN students on attendance.student_id = students.id WHERE attendance.month =".$month." AND attendance.year =".$year." AND students.program_name=:program AND attendance.form_submitted = 1 GROUP BY students.id ";
	} 
	$stmt2 = $db->prepare($str);

	$stmt2->bindParam("program", $program,PDO::PARAM_STR);
	$stmt2->execute();
	$data=$stmt2->fetchAll(PDO::FETCH_ASSOC);
   }
   // Cumulative leaves of individual students for stipend eligible
   else {

	if($ptype == "ALL")
	{
		$str = "SELECT students.name as name, students.gender as gender , students.rollno as rollno , attendance.payable as payable, SUM(attendance.contingency) as cl , SUM(attendance.sanctioned) as sl , SUM(attendance.medical) as ml , SUM(attendance.maternity) as maternity , SUM(attendance.duty) as duty , SUM(attendance.work_off) as wo  FROM attendance LEFT JOIN students on attendance.student_id = students.id WHERE attendance.month =".$month." AND attendance.year =".$year." AND students.program_name=:program AND students.stipend_eligible=1 GROUP BY students.id";
	}  
	else
	{
		$str = "SELECT students.name as name, students.gender as gender , students.rollno as rollno , attendance.payable as payable, SUM(attendance.contingency) as cl , SUM(attendance.sanctioned) as sl , SUM(attendance.medical) as ml , SUM(attendance.maternity) as maternity , SUM(attendance.duty) as duty , SUM(attendance.work_off) as wo  FROM attendance LEFT JOIN students on attendance.student_id = students.id WHERE attendance.month =".$month." AND attendance.year =".$year." AND students.program_name=:program AND students.stipend_eligible=1 AND attendance.form_submitted = 1 AND attendance.processed_date = '".$processed_date."' GROUP BY students.id ";
	} 

	$stmt2 = $db->prepare($str);

	$stmt2->bindParam("program", $program,PDO::PARAM_STR);
	$stmt2->execute();
	$data=$stmt2->fetchAll(PDO::FETCH_ASSOC);	
   }


	//echo print_r($data);
	//Fetch program details
    $stmt=$db->prepare("SELECT * from program where program_name=:programme");
    $stmt->bindParam("programme", $program,PDO::PARAM_STR);
	$stmt->execute();
	$data2=$stmt->fetchAll(PDO::FETCH_ASSOC);
	
	//month wise present-absent for all
   if($stype=='ALL')
   {

	if($ptype == "ALL")
	{
		$str = "SELECT * from attendance join students ON attendance.student_id = students.id where students.program_name=:program AND month=:m and year=:y  ORDER BY student_id";
	}
	else
	{
		$str = "SELECT * from attendance join students ON attendance.student_id = students.id where month=:m and year=:y and students.program_name=:program and attendance.form_submitted = 1 ORDER BY student_id";
	}

	$stmt3 = $db->prepare($str);
	$stmt3->bindParam("m", $month,PDO::PARAM_STR);
	$stmt3->bindParam("y", $year,PDO::PARAM_STR);
	$stmt3->bindParam("program", $program,PDO::PARAM_STR);
	$stmt3->execute();
	$data3=$stmt3->fetchAll(PDO::FETCH_ASSOC);
   }
   //month wise present-absent for stipend eligible
   else{
	   if($ptype== "ALL")
	   $str = "SELECT * from attendance join students ON attendance.student_id = students.id where month=:m and year=:y and students.program_name=:program and students.stipend_eligible=1 ORDER BY student_id";
	   else
	   $str = "SELECT * from attendance join students ON attendance.student_id = students.id where month=:m and year=:y and students.program_name=:program and students.stipend_eligible=1 AND attendance.form_submitted = 1 AND attendance.processed_date = '".$processed_date."' ORDER BY student_id";
	$stmt3 = $db->prepare($str);
	$stmt3->bindParam("m", $month,PDO::PARAM_STR);
	$stmt3->bindParam("y", $year,PDO::PARAM_STR);
	$stmt3->bindParam("program", $program,PDO::PARAM_STR);
	$stmt3->execute();
	$data3=$stmt3->fetchAll(PDO::FETCH_ASSOC);
   }

 //  echo $stype;
 //  echo $ptype;

   if($stype == "ALL")
   {
	   if($ptype == "ALL")
	{
	//	echo 1;
	   $str = "SELECT DISTINCT students.id, IFNULL( (

		SELECT SUM( amount )
		FROM deductions
		WHERE student_id = students.id
		AND month =:m
		AND year =:y ) , 0
		)amount
		FROM `deductions`
		RIGHT JOIN students ON deductions.student_id = students.id
		JOIN attendance ON attendance.student_id = students.id
		WHERE attendance.month=:m AND attendance.year=:y AND students.program_name = '".$program."' ORDER BY students.id";
	}
	else
	{
	//	echo 2;
		$str = "SELECT DISTINCT students.id, IFNULL( (

			SELECT SUM( amount )
			FROM deductions
			WHERE student_id = students.id
			AND month=:m
			AND year =:y ) , 0
			)amount
			FROM `deductions`
			RIGHT JOIN students ON deductions.student_id = students.id
			JOIN attendance ON attendance.student_id = students.id
			WHERE attendance.form_submitted =1 AND attendance.month=:m AND attendance.year=:y AND students.program_name = '".$program."' ORDER BY students.id";

	}
	$stmt4 = $db->prepare($str);
	$stmt4->bindParam("m", $month,PDO::PARAM_STR);
	$stmt4->bindParam("y", $year,PDO::PARAM_STR);
	$stmt4->execute();
	$data4=$stmt4->fetchAll(PDO::FETCH_ASSOC);	
   }
   else
   {
	   if($ptype == "ALL")
		{
	//		echo 3;
		$str = "SELECT DISTINCT students.id, IFNULL( (

		SELECT SUM( amount )
		FROM deductions
		WHERE student_id = students.id
		AND  month =:m
		AND year =:y ) , 0
		)amount
		FROM `deductions`
		RIGHT JOIN students ON deductions.student_id = students.id
		JOIN attendance ON attendance.student_id = students.id
		WHERE students.stipend_eligible=1 AND attendance.month=:m AND attendance.year=:y AND students.program_name = '".$program."' ORDER BY students.id";
		}

		else 
		{
	//		echo 4;
			$str = "SELECT DISTINCT students.id, IFNULL( (

				SELECT SUM( amount )
				FROM deductions
				WHERE student_id = students.id
				AND month =:m
				AND year =:y ) , 0
				)amount
				FROM `deductions`
				RIGHT	 JOIN students ON deductions.student_id = students.id
				JOIN attendance ON attendance.student_id = students.id
				WHERE students.stipend_eligible=1 AND attendance.form_submitted =1 AND attendance.processed_date = '".$processed_date."' AND attendance.month=:m AND attendance.year=:y AND students.program_name = '".$program."'  ORDER BY students.id";
		}
		$stmt4 = $db->prepare($str);
		$stmt4->bindParam("m", $month,PDO::PARAM_STR);
		$stmt4->bindParam("y", $year,PDO::PARAM_STR);
		$stmt4->execute();
		$data4=$stmt4->fetchAll(PDO::FETCH_ASSOC);
}



$oneDimensionalArray = array_map('current', $data4);

//echo($data4[393]['amount']);

//echo $str;
	
   // echo print_r($data2);    
	 $pdf->SetFont('Arial','',10);
	
	 $pdf->AddPage();
	

	 $pdf->FancyTable($header,$header2,$data,$data2,$data3,$data4,$oneDimensionalArray);
	 $pdf->Output();

?>