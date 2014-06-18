<?php
//-*-coding: utf-8 -*-
class Invoice
{
	private $fileName;
	private $image;
	private $outFile;
	public function __construct($fileName)
	{
		$this->fileName=$fileName;
	}
	function create($fio,$num,$price)
	{
		set_include_path(get_include_path().":".Config::$dir0."/fpdf");
		$img=imagecreatefrompng($this->fileName);
		$color=imagecolorallocate($img,0,0,0);
		$text=$fio;
		$x0=470;
		$y0=375;
		$font=Config::$dir0."/fonts/Arial.ttf";
		$sumKoords=array("x"=>740,"y"=>535);
		$sum2Koords=array("x"=>740,"y"=>1010);
		$numKoords=array("x"=>725,"y"=>70);
		$num2Koords=array("x"=>480,"y"=>482);
		$num3Koords=array("x"=>480,"y"=>958);
		imagettftext($img,14,0,$x0,$y0,$color,$font,$text);
		$y0=855;
		imagettftext($img,14,0,$x0,$y0,$color,$font,$text);
		$text=$price." грн.";
		imagettftext($img,14,0,$sumKoords["x"],$sumKoords["y"],$color,$font,$text);
		imagettftext($img,14,0,$sum2Koords["x"],$sum2Koords["y"],$color,$font,$text);
		$text="№ ".$num;
		imagettftext($img,14,0,$numKoords["x"],$numKoords["y"],$color,$font,$text);
		imagettftext($img,14,0,$num2Koords["x"],$num2Koords["y"],$color,$font,$text);
		imagettftext($img,14,0,$num3Koords["x"],$num3Koords["y"],$color,$font,$text);
		$text=date("d.m.Y");
		imagettftext($img,14,0,345,500,$color,$font,$text);
		imagettftext($img,14,0,345,985,$color,$font,$text);
		$imgFile=Config::$dir0."/temp/".md5(uniqid()).".png";
		imagepng($img,$imgFile);
		require_once('fpdf.php');
		//create a FPDF object
		$pdf=new FPDF();
		//set document properties
		$pdf->SetAuthor('777tur.com');
		$pdf->SetTitle('invoice for tickets');
		//set font for the entire document
		$pdf->SetFont('Helvetica','B',20);
		$pdf->SetTextColor(50,60,100);
		//set up a page
		$pdf->AddPage('P','A4');
		$pdf->SetDisplayMode('real','default');
		//insert an image and make it a link
		$pdf->Image($imgFile,10,10,170,170);
		//display the title with a border around it
		$pdf->SetXY(50,20);
		$pdf->SetDrawColor(50,60,100);
		//Set x and y position for the main text, reduce font size and write content
		$pdf->SetXY (10,50);
		$pdf->SetFontSize(10);
		//Output the document
		
		$pdfFile=Config::$dir0."/temp/invoice".md5(uniqid()).".pdf";
		$pdf->Output($pdfFile,'F');
		unlink($imgFile);
		$this->pdfFile=$pdfFile;
		return $pdfFile;
	}
 

}