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
	$this->Cell(0,0,"Deputy Registrar(A&A)",0,0,'L');
}
function FancyTable($header, $data)
	{
		
		$this->SetFont('Arial','',10);
	//	$months=array('Jan',"Feb",'Mar','May','Apr','May','Jun','Jul','Aug','Sept',"Oct",'Nov','Dec');

	//	$month_ver = $months[$month].'-'.+$year%100;
		
//		$count=0;
        $w = array(13, 50, 40, 40, 40);
        for($i=0;$i<count($header);$i++)
			$this->Cell($w[$i],6,$header[$i],1,0,'C');
		$this->Ln();
		$count=0;
		// $cldates=[];
		// $sldates=[];
		// $mldates=[];
		// $maternitydates=[];
		// $dutydates=[];
		// foreach($data as $row)
		// {
		// 	if($row['types']=='cl')
        //         array_push($cldates,$row['dates']);
		// }
		//  $count=max($count, sizeof($cldates));

		// foreach($data as $row)
		// {
		// 	if($row['types']=='ml')
		// 		array_push($mldates,$row['dates']);
			
		// }
		// $count=max($count, sizeof($mldates));

		// foreach($data as $row)
		// {
		// 	if($row['types']=='sl')
		// 	array_push($sldates,$row['dates']);
			
		// }
		// $count=max($count, sizeof($sldates));

		// foreach($data as $row)
		// {
		// 	if($row['types']=='maternity')
		// 	array_push($maternitydates,$row['dates']);
			
		// }
		// $count=max($count, sizeof($maternitydates));

		// foreach($data as $row)
		// {
		// 	if($row['types']=='duty')
		// 	array_push($dutydates,$row['dates']);
			
		// }
		// $count=max($count, sizeof($dutydates));


		// for($i=0;$i<count($header);$i++)
		// 	$this->Cell($w[$i],5,$header[$i],1,0,'C');
		// $this->Ln();
        
        

        foreach($data as $row)
        {
            $count++;
            $this->Cell($w[0],5,$count,'LRB');
			$this->Cell($w[1],5,$row['name'],'LRB');
			$this->Cell($w[2],5,$row['rollno'],'LRB');
			$this->Cell($w[3],5,$row['type'],'LRB');
			$this->Cell($w[4],5,$row['amount'],'LRB');
		//	$this->Cell($w[5],5,$dutydates[$i],'LR');
			$this->Ln();
        }

		// for($i=0; $i<$count;$i++)
		// {
		//  	$this->Cell($w[0],5,$i+1,'LR');
		// 	$this->Cell($w[1],5,$cldates[$i],'LR');
		// 	$this->Cell($w[2],5,$mldates[$i],'LR');
		// 	$this->Cell($w[3],5,$sldates[$i],'LR');
		// 	$this->Cell($w[4],5,$maternitydates[$i],'LR');
		// 	$this->Cell($w[5],5,$dutydates[$i],'LR');
		// 	$this->Ln();
		// }
		
		 //$this->Cell(array_sum($w),0,'','T');
		//  //$this->Ln();
		//  $this->Cell($w[0],5,'Total','LRTB');
		// $this->Cell($w[1],5,sizeof($cldates),'LRTB');
		// $this->Cell($w[2],5,sizeof($mldates),'LRTB');
		// $this->Cell($w[3],5,sizeof($sldates),'LRBT');
		// $this->Cell($w[4],5,sizeof($maternitydates),'LTRB');
		// $this->Cell($w[5],5,sizeof($dutydates),'LRTB');
		// //$this->Cell(array_sum($w),0,'','T');
			
		
	}

}
	$pdf = new PDF('L');
    

    $month = $_GET['month'];
    $year = $_GET['year'];
    $program = $_GET['program'];
    $header = array('S.No.','Name','Roll No.','Deduction Type','Amount');
    
	$db = getDB();
	$stmt2 = $db->prepare("SELECT * FROM deductions JOIN deduction_types ON  deductions.deduction_type = deduction_types.id JOIN students ON deductions.student_id = students.id   WHERE deductions.month = :m AND deductions.year = :y AND students.program_name = :program ORDER BY students.id");
	$stmt2->bindParam("m", $month,PDO::PARAM_STR);
	$stmt2->bindParam("y", $year,PDO::PARAM_STR);
	$stmt2->bindParam("program", $program,PDO::PARAM_STR);
	$stmt2->execute();
	$data=$stmt2->fetchAll(PDO::FETCH_ASSOC);
	$pdf->SetFont('Arial','',10);
	$pdf->AddPage();
	// $rollno=$data[0]['rollno'];
	// $name=$data[0]['name'];
	// $pdf->Cell(0,0,"Roll Number: ".$rollno,0,0,'L');
	// $pdf->Ln(5);
	// $pdf->Cell(0,0,"Name: ".$name,0,0,'L');
	// $pdf->Ln(10);
	$pdf->FancyTable($header,$data);
	$pdf->Output();

?>