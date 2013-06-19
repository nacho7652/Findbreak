<?php 



	header('Content-Type: text/html; charset=UTF-8');

	date_default_timezone_set('America/Santiago');

	error_reporting(0);



	function removeCode($str){

		$busqueda = array (	 '@<script[^>]*?>.*?</script>@si',

			                /* '@<[\/\!]*?[^<>]*?>@si', */        

			                 '@([\r\n])[\s]+@',               

			                 '@&(quot|#34);@i',              

			                 '@&(amp|#38);@i',

			                 '@&(lt|#60);@i',

			                 '@&(gt|#62);@i',

			                 '@&(nbsp|#160);@i',

			                 '@&(iexcl|#161);@i',

			                 '@&(cent|#162);@i',

			                 '@&(pound|#163);@i',

			                 '@&(copy|#169);@i',

			                 '@&#(\d+);@e');                   

		

		$reemplazar = array ('',

		          /*        '', */

 		                  '\1',

		                  '"',

		                  '&',

		                  '<',

		                  '>',

		                  ' ',

		                  chr(161),

		                  chr(162),

		                  chr(163),

		                  chr(169),

		                  'chr(\1)');

		

		$texto = preg_replace($busqueda, $reemplazar, $str);

		return $texto;

	}





	function utf8_safe($string){

		$string = trim($string);

		if(mb_detect_encoding($string)=='UTF-8'){ 

	    	return $string; 

	 	}else{ 

	    	return utf8_encode($string); 

	 	} 

	}





	function quote($string, $on = true){

		if($on)

			$string = empty($string) ? "''" : "'".$string."'";



		return $string ;

	}





	function clearDir($string, $quote = true, $allowdot = false){

		$string = utf8_safe($string);

		$string = removeCode($string);

		



		$search =  explode(",","Ã„,Ã‹,Ã¯,Ã–,Ãœ,Ã¡,Ã ,Ã¢,Ã£,Âª,Ã�,Ã€,Ã‚,Ãƒ,Ã©,Ã¨,Ãª,Ã‰,Ãˆ,ÃŠ,Ã­,Ã¬,Ã®,Ã�,ÃŒ,ÃŽ,Ã³,Ã²,Ã´,Ãµ,Âº,Ã“,Ã’,Ã”,Ã•,Ãº,Ã¹,Ã»,Ãš,Ã™,Ã›,Ã±,Ã‘");

	 	$replace = explode(",","A,E,I,O,U,a,a,a,a,a,A,A,A,A,e,e,e,E,E,E,i,i,i,I,I,I,o,o,o,o,o,O,O,O,O,u,u,u,U,U,U,n,N");

		$string = str_replace($search, $replace, $string);
                $string = preg_replace("/[^a-zA-Z0-9_ \.-]/", "_", $string);

              

		if(!$allowdot)
			$string = strtr($string, array("." => "_"));



		$string = trim($string);

		$string = strtr($string, array(" " => "-"));



		$search =  array("/[-\s]+/","/[_\s]+/","/(_-)+/","/(-_)+/","/^[\-_\s]+/","/[\-_\s]+$/");

	 	$replace = array("-","_","-","-","","");

		

		$string = preg_replace($search, $replace, $string);



		return ($quote) ? quote($string) : $string;

	}



	function clearMail($string, $quote = true){

		$string = removeCode($string);

		$string = utf8_safe($string);		



		$string = preg_replace("/[^a-zA-Z0-9@_\.-]/", "", $string);



		return ($quote) ? quote($string) : $string;

	}





	function clearInt($string, $quote = false){

		$string = utf8_safe($string);	

		$string = removeCode($string);

			



		$string = preg_replace("/[^0-9]/", "", $string);



		return ($quote) ? quote($string) : $string;

	}



	function safeForDB($string, $quote = true){

		$string = utf8_safe($string);	

		$string = removeCode($string);

		



		$array = array(

					        "\0" => "",

					        "'"  => "&#39;",

					        "\"" => "&#34;",

					        "\\" => "&#92;",

					        "<"  => "&lt;",

					        ">"  => "&gt;",

					    );



		$string = strtr($string, $array );



		if (function_exists('addslashes'))

           	$string = addslashes($string);

        else

	        $string = mysql_real_escape_string($string);



		return ($quote) ? quote($string) : $string;

	}









?>