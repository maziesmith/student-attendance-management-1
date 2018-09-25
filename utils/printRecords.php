<?php

include('config.php');
include('mainClass.php');
$student_id='';
$program_name='IPG';
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
$x=1;
$sum_amount=0;
$GLOBALS['program_name'] = $program_name;
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
	$program_name=$params['program_name'];
	$month = $params['month'];
	$processed_date = $params['processed_date'];
	$year = $params['year'];
}




require('../fpdf181/fpdf.php');
class PDF extends FPDF

{

function Header()
{

	$this->SetFont('Arial','',15);
		$this->Image('logo_mid.png',5,1,'PNG');
		$this->Cell(15);
		$this->Cell(0,0,"ABV-Indian Institute of Information Technology and Management, Gwalior",0,0,'C');
		$this->Ln(25);
		
}

function FancyTable($header, $data, $month,$year,$processed_date,$program_name,$data4)
	{
		
		$this->SetFont('Arial','',8);
		$months=array('Jan',"Feb",'Mar','Apr','May','Jun','Jul','Aug','Sept',"Oct",'Nov','Dec');

		$month_ver = $months[$month-1].'-'.+$year%100;
		
		$count=0;
		$w = array(13, 30, 70, 45,20,20);
		
		for($i=0;$i<count($header);$i++)
			$this->Cell($w[$i],6,$header[$i],1,0,'C');
		$this->Ln();
		$sum_amount=0;
		foreach($data as $row)
		{

			$count++;
			$this->Cell($w[0],7,$count,'LRB');
			$this->Cell($w[1],7,$row['rollno'],'LRB');
			$this->Cell($w[2],7,$row['name'],'LRB');
			$this->Cell($w[3],7,$row['account'],'LBR');
			$this->Cell($w[4],7,$month_ver,'LRB');
			$this->Cell($w[5],7,number_format($row['payable'] - $data4[$count-1]['amount']),'LBR');
			$sum_amount=$sum_amount+$row['payable'] - $data4[$count-1]['amount'];
		//	$this->Cell($w[6],7,$processed_date,'LR');
			$this->Ln();
		}
		
		$this->Cell(array_sum($w),0,'','T');
		$this->Ln(2);
		$this->SetFont('Arial','',10);
		$total_str="Total: ".number_format($sum_amount);
		$this->Cell(0,7,$total_str,0,0,'R');
		
	}

}
	$pdf = new PDF();
	
	$header = array('S.No.','Roll Number','Name','Account No','Month','Payable');
	$db = getDB();
	$stmt2 = $db->prepare("SELECT students.name as name,students.rollno as rollno,students.bank_ac_number as account,payable , processed_date	 FROM attendance LEFT JOIN students on attendance.student_id = students.id WHERE month=:month AND year=:year AND students.stipend_eligible=1 AND attendance.program_id=(SELECT id FROM program WHERE program_name = :program_name  ) AND attendance.processed_date=:processed_date ");

	$stmt2->bindParam("program_name", $program_name,PDO::PARAM_STR);
	$stmt2->bindParam("month", $month);
	$stmt2->bindParam("year", $year);
	$stmt2->bindParam("processed_date", $processed_date);
	$stmt2->execute();
	$data=$stmt2->fetchAll(PDO::FETCH_ASSOC);

	$str = "SELECT DISTINCT students.id, IFNULL( (

		SELECT SUM( amount )
		FROM deductions
		WHERE student_id = students.id
		AND MONTH =:m
		AND year =:y ) , 0
		)amount
		FROM `deductions`
		RIGHT JOIN students ON deductions.student_id = students.id
		JOIN attendance ON attendance.student_id = students.id
		WHERE students.stipend_eligible=1 AND attendance.month=:m AND attendance.year=:y AND attendance.form_submitted =1 AND attendance.program_id=(SELECT id FROM program WHERE program_name = :program_name  )  AND  attendance.processed_date=:processed_date
				";

	$stmt4 = $db->prepare($str);
	$stmt4->bindParam("m", $month,PDO::PARAM_STR);
	$stmt4->bindParam("y", $year,PDO::PARAM_STR);
	$stmt4->bindParam("program_name", $program_name,PDO::PARAM_STR);
	$stmt4->bindParam("processed_date", $processed_date);
	$stmt4->execute();
	$data4=$stmt4->fetchAll(PDO::FETCH_ASSOC);
	//print_r($data4);

	$pdf->SetFont('Arial','',10);
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',10);
	$dt = new DateTime();
	$to_be_printed ="ABV-IIITM/F&A/Reg./"; 
	$pdf->Cell(0,0,$to_be_printed,0,0,'L');
	$pdf->Ln(5);
	$dt = new DateTime();
	$pdf->Cell(0,0,$dt->format('d-m-Y'),0,0,'L');
	$pdf->SetFont('Arial','',10);
	$pdf->Ln(10);
	$pdf->Cell(0,0,"From: Joint Registrar(A&A)",0,0,'L');
	$pdf->Ln(10);
	$pdf->Cell(0,0,"To: The Branch Manager,",0,0,'L');
	$pdf->Ln(5);
	$pdf->cell(6.5);
	$pdf->Cell(0,0,"Bank Of India,",0,0,'L');
	$pdf->Ln(5);
	$pdf->cell(6.5);
	$pdf->Cell(0,0,"ABV-IIITM, Gwalior",0,0,'L');
	$pdf->Ln(10);

	foreach($data as $row)
	{
		$sum_amount=$sum_amount+$row['payable'];
	}

	$str = "We are enclosing  a Cheque No. __________________  dated  _____________  amounting to Rs. ______________ towards";
	$str2 = "assistance ship payable to ". $GLOBALS['program_name']. " students.  You are requested to transfer the amount as per list below, in the individual";
	$str3 = "account numbers of respective students.";
	$pdf->Cell(0,0,$str,0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(0,0,$str2,0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(0,0,$str3,0,0,'L');
	$pdf->Ln(10);
	$pdf->Ln(5);
	$pdf->FancyTable($header,$data,$month,$year,$processed_date,$program_name,$data4);
	
	$pdf->Ln(20);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(0,0,"Joint Registrar(A&A)",0,0,'L');
	$pdf->Output();

?>