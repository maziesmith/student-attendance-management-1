<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
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
	$rollno=$params['rollno'];
	//echo $params;
	 $session = $params['session'];
	// echo $session;
	 $begin_year = substr($session,0,strpos($session,'-'));
	 $end_year = substr($session,strpos($session,'-')+1);
	 
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

function Footer()
{
	$this->Ln(20);
	$this->SetFont('Arial','B',10);
	$this->Cell(0,0,"Joint Registrar(A&A)",0,0,'L');
}
function FancyTable($header, $data)
	{
		
		$this->SetFont('Arial','',10);
	//	$months=array('Jan',"Feb",'Mar','May','Apr','May','Jun','Jul','Aug','Sept',"Oct",'Nov','Dec');

	//	$month_ver = $months[$month].'-'.+$year%100;
		
//		$count=0;
		$w = array(13, 40, 40, 40, 40, 40);
		$count=0;
		$cldates=[];
		$sldates=[];
		$mldates=[];
		$maternitydates=[];
		$dutydates=[];
		foreach($data as $row)
		{
			if($row['types']=='cl')
                array_push($cldates,$row['dates']);
		}
		 $count=max($count, sizeof($cldates));

		foreach($data as $row)
		{
			if($row['types']=='ml')
				array_push($mldates,$row['dates']);
			
		}
		$count=max($count, sizeof($mldates));

		foreach($data as $row)
		{
			if($row['types']=='sl')
			array_push($sldates,$row['dates']);
			
		}
		$count=max($count, sizeof($sldates));

		foreach($data as $row)
		{
			if($row['types']=='maternity')
			array_push($maternitydates,$row['dates']);
			
		}
		$count=max($count, sizeof($maternitydates));

		foreach($data as $row)
		{
			if($row['types']=='duty')
			array_push($dutydates,$row['dates']);
			
		}
		$count=max($count, sizeof($dutydates));


		for($i=0;$i<count($header);$i++)
			$this->Cell($w[$i],5,$header[$i],1,0,'C');
		$this->Ln();
		

		for($i=0; $i<$count;$i++)
		{
		 	$this->Cell($w[0],5,$i+1,'LR');
			$this->Cell($w[1],5,$cldates[$i],'LR');
			$this->Cell($w[2],5,$mldates[$i],'LR');
			$this->Cell($w[3],5,$sldates[$i],'LR');
			$this->Cell($w[4],5,$maternitydates[$i],'LR');
			$this->Cell($w[5],5,$dutydates[$i],'LR');
			$this->Ln();
		}
		
		 //$this->Cell(array_sum($w),0,'','T');
		 //$this->Ln();
		 $this->Cell($w[0],5,'Total','LRTB');
		$this->Cell($w[1],5,sizeof($cldates),'LRTB');
		$this->Cell($w[2],5,sizeof($mldates),'LRTB');
		$this->Cell($w[3],5,sizeof($sldates),'LRBT');
		$this->Cell($w[4],5,sizeof($maternitydates),'LTRB');
		$this->Cell($w[5],5,sizeof($dutydates),'LRTB');
		//$this->Cell(array_sum($w),0,'','T');
			
		
	}

}
	$pdf = new PDF('L');
    
	$header = array('S.No.','CL','ML','SL','Maternity','Duty');
	$db = getDB();
	$begin_date = "01/07/".$begin_year;
	$end_date = "31/05/".$end_year;
	//echo $end_date;

	 $stmt2 = $db->prepare("SELECT students.name as name,students.rollno as rollno , dateattendance.dates as dates , dateattendance.type as types FROM dateattendance LEFT JOIN students on dateattendance.student_id = students.id WHERE students.rollno=:rollno AND (str_to_date(dateattendance.dates, '%d/%m/%Y')  > str_to_date('".$begin_date."', '%d/%m/%Y') AND str_to_date(dateattendance.dates, '%d/%m/%Y') < str_to_date('".$end_date."', '%d/%m/%Y'))");

	 $stmt2->bindParam("rollno", $rollno,PDO::PARAM_STR);
	 $stmt2->execute();
	 $data=$stmt2->fetchAll(PDO::FETCH_ASSOC);
	// print_r($data);
	$pdf->SetFont('Arial','',10);
	$pdf->AddPage();
	$rollno=$data[0]['rollno'];
	$name=$data[0]['name'];
	//echo $name;
	$pdf->Cell(0,0,"Roll Number: ".$rollno,0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(0,0,"Name: ".$name,0,0,'L');
	$pdf->Ln(10);
	$pdf->FancyTable($header,$data);
	$pdf->Output();

?>