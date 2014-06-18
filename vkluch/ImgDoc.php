<?php
//-*-coding: utf-8 -*-
class ImgDoc
{
	private $filePic;
	private $aText=array();
	private $font;
	private $fontSize;
	private $outFile;
	private $pdfFile;
	private $title;
	
	
	public function __construct($fileName)
	{
		$this->filePic=$fileName;
		$this->font=Config::$dir0."/fonts/Arial.ttf";
		$this->fontSize=14;
	}
	public function addText($x,$y,$text)
	{
		$this->aText[]=array("x"=>$x,"y"=>$y,"text"=>$text);
	}
	public function create()
	{
		$img=imagecreatefrompng($this->filePic);
		$color=imagecolorallocate($img,0,0,0);
		foreach($this->aText as $num=>$aTData)
		{
			imagettftext($img,$this->fontSize,0,$aTData["x"],$aTData["y"],$color,$this->font,$aTData["text"]);
		};
		$imgFile=Config::$dir0."/temp/".md5(uniqid()).".png";
		imagepng($img,$imgFile);
		$this->filePic=$imgFile;
		return $imgFile;
	}
	public function createPdf($prefix="")
	{
		set_include_path(get_include_path().":".Config::$dir0."/fpdf");
		require_once('fpdf.php');
		$pdf=new FPDF();
		//set document properties
		$pdf->SetAuthor('777tur.com');
		$pdf->SetTitle('doc for tickets');
		//set up a page
		$pdf->AddPage('P','A4');
		$pdf->SetDisplayMode('real','default');
		//insert an image and make it a link
		$w=170;
		$h=floor(831*$w/1240);
		$pdf->Image($this->filePic,10,10,$w,$h);
		$pdfFile=Config::$dir0."/temp/".$prefix.md5(uniqid()).".pdf";
		$pdf->Output($pdfFile,'F');
		unlink($filePic);
		$this->pdfFile=$pdfFile;
		return $pdfFile;
	}
}
