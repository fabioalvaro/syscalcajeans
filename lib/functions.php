<?php
	class Functions
	{			
		 public static function dbdate ( $data )
		 {
		 	if( trim( $data ) == '' )
			{
			   return '';	
			}
			
		 	if($data == "00/00/0000" )
			{
		 	   return ''; 
			} 
    		$dia =strval(substr($data,0,2)); 
    		$mes =strval(substr($data,3,2)); 
    		$ano =strval(substr($data,6,4));
			
			if( checkdate($mes,$dia,$ano) )
			{
				return @date("Y-m-d",  @mktime(0,0,0,$mes,$dia,$ano));
			}
			else
			{
				return '';
			} 
		 }
		 
		 public static function brdate ( $data )
		 {
		 	if( $data == "0000-00-00" )
			{ 
		 	   return '';
			} 
    		$ano =strval(substr($data,0,4)); 
    		$mes =strval(substr($data,5,2)); 
    		$dia =strval(substr($data,8,2)); 
    		return @date("d/m/Y",  @mktime(0,0,0,$mes,$dia,$ano));
		 }
	}
?>