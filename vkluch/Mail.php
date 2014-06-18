<?php
//-*-coding: utf-8 -*-
/*class Pisar implements Worker
{
	private $fields;
	private $tmpl;
	public function __construct($tmpl)
	{
		$this->tmpl=$tmpl;
	}
	public function work($obj)
	{
		$this->fields[]=$obj;
	}
	public function compile()
	{
		require($this->tmpl);
	}
}*/
class Mail
{
	private $to;
	private $from;
	private $subject;
	private $pathAttach;
	private $name;// в этой переменной надо сформировать имя файла (без всякого пути) 
	private $EOL="\n";
	private $boundary; 
		
	public function __construct($to,$from,$subject,$pathAttach,$name="счет.pdf")
	{
		$this->to=$to;
		$this->from=$from;
		$this->subject=$subject;
		$this->pathAttach=$pathAttach;
		$this->name=$name;
		$this->boundary= "--".md5(uniqid());   // любая строка, которой не будет ниже в потоке данных. 
	}
	public function send($text)
	{
		if ($this->pathAttach)
		{  
			$fp = fopen($this->pathAttach,"rb");   
			if (!$fp)   
			{ 
				print "Cannot open file ".$this->pathAttach;   
				exit();   
			}   
			$file = fread($fp, filesize($this->pathAttach));   
			fclose($fp);   
		};
		$headers    = "MIME-Version: 1.0;".$this->EOL;
		$headers   .= "Content-Type: multipart/mixed; boundary=\"".$this->boundary."\"".$this->EOL;
		$headers   .= "From: ".$this->from;  
		    
		$multipart  = "--".$this->boundary.$this->EOL;   
		$multipart .= "Content-Type: text/html; charset=utf-8".$this->EOL;
		$multipart .= "Content-Transfer-Encoding: base64".$this->EOL;
		$multipart .= $this->EOL; // раздел между заголовками и телом html-части 
		$multipart .= chunk_split(base64_encode($text));   

		$multipart .=  $this->EOL."--".$this->boundary.$this->EOL;   
		$multipart .= "Content-Type: application/octet-stream; name=\"".$this->name."\"".$this->EOL;
		$multipart .= "Content-Transfer-Encoding: base64".$this->EOL;   
		$multipart .= "Content-Disposition: attachment; filename=\"".$this->name."\"".$this->EOL;
		$multipart .= $this->EOL; // раздел между заголовками и телом прикрепленного файла 
		$multipart .= chunk_split(base64_encode($file));   

		$multipart .= $this->EOL."--".$this->boundary."--".$this->EOL;
			      
		if(!mail($this->to, $this->subject, $multipart, $headers))   
		{
			return(1);      

			//если не письмо не отправлено
		}  
		else 
		{ //// если письмо отправлено
		
			//unlink($this->pathAttach);
			return (0); 
		};
			  
		    
	}
	public function clearFiles()
	{
		if(file_exists($this->pathAttach))
		{
			unlink($this->pathAttach);
		};
	}
}