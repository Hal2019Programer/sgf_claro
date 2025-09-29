<?php
spl_autoload_extensions(".class.php, .php, .inc");
spl_autoload_register("my_autoload");
set_error_handler("handleWarningAvise");
error_reporting(E_ALL);
ini_set('display_errors',1);

function my_autoload($nomArchivo){
    //$path_class=array('./class/');
    $archivo="./class/".$nomArchivo.".php";
	if(file_exists(__DIR__.'/'.$nomArchivo.".php")){
		require_once __DIR__.'/'.$nomArchivo.".php";
	}elseif(file_exists("./class/fpdf/".$nomArchivo.".php")){
		$archivo="../class/fpdf/".$nomArchivo.".php";
		require_once($archivo);
	}	
}

function getPlataform($user_agent){
	if(strpos($user_agent, 'Windows NT 10.0') !== FALSE)
        return "Windows 10";
    elseif(strpos($user_agent, 'Windows NT 6.3') !== FALSE)
        return "Windows 8.1";
    elseif(strpos($user_agent, 'Windows NT 6.2') !== FALSE)
        return "Windows 8";
    elseif(strpos($user_agent, 'Windows NT 6.1') !== FALSE)
        return "Windows 7";
    elseif(strpos($user_agent, 'Windows NT 6.0') !== FALSE)
        return "Windows Vista";
    elseif(strpos($user_agent, 'Windows NT 5.1') !== FALSE)
        return "Windows XP";
    elseif(strpos($user_agent, 'Windows NT 5.2') !== FALSE)
        return 'Windows 2003';
    elseif(strpos($user_agent, 'Windows NT 5.0') !== FALSE)
        return 'Windows 2000';
    elseif(strpos($user_agent, 'Windows ME') !== FALSE)
        return 'Windows ME';
    elseif(strpos($user_agent, 'Win98') !== FALSE)
        return 'Windows 98';
    elseif(strpos($user_agent, 'Win95') !== FALSE)
        return 'Windows 95';
    elseif(strpos($user_agent, 'WinNT4.0') !== FALSE)
        return 'Windows NT 4.0';
    elseif(strpos($user_agent, 'Windows Phone') !== FALSE)
        return 'Windows Phone';
    elseif(strpos($user_agent, 'Windows') !== FALSE)
        return 'Windows';
    elseif(strpos($user_agent, 'iPhone') !== FALSE)
        return 'iPhone';
    elseif(strpos($user_agent, 'iPad') !== FALSE)
        return 'iPad';
    elseif(strpos($user_agent, 'Debian') !== FALSE)
        return 'Debian';
    elseif(strpos($user_agent, 'Ubuntu') !== FALSE)
        return 'Ubuntu';
    elseif(strpos($user_agent, 'Slackware') !== FALSE)
        return 'Slackware';
    elseif(strpos($user_agent, 'Linux Mint') !== FALSE)
        return 'Linux Mint';
    elseif(strpos($user_agent, 'Gentoo') !== FALSE)
        return 'Gentoo';
    elseif(strpos($user_agent, 'Elementary OS') !== FALSE)
        return 'ELementary OS';
    elseif(strpos($user_agent, 'Fedora') !== FALSE)
        return 'Fedora';
    elseif(strpos($user_agent, 'Kubuntu') !== FALSE)
        return 'Kubuntu';
    elseif(strpos($user_agent, 'Linux') !== FALSE)
        return 'Linux';
    elseif(strpos($user_agent, 'FreeBSD') !== FALSE)
        return 'FreeBSD';
    elseif(strpos($user_agent, 'OpenBSD') !== FALSE)
        return 'OpenBSD';
    elseif(strpos($user_agent, 'NetBSD') !== FALSE)
        return 'NetBSD';
    elseif(strpos($user_agent, 'SunOS') !== FALSE)
        return 'Solaris';
    elseif(strpos($user_agent, 'BlackBerry') !== FALSE)
        return 'BlackBerry';
    elseif(strpos($user_agent, 'Android') !== FALSE)
        return 'Android';
    elseif(strpos($user_agent, 'Mobile') !== FALSE)
        return 'Firefox OS';
    elseif(strpos($user_agent, 'Mac OS X+') || strpos($user_agent, 'CFNetwork+') !== FALSE)
        return 'Mac OS X';
    elseif(strpos($user_agent, 'Macintosh') !== FALSE)
        return 'Mac OS Classic';
    elseif(strpos($user_agent, 'OS/2') !== FALSE)
        return 'OS/2';
    elseif(strpos($user_agent, 'BeOS') !== FALSE)
        return 'BeOS';
    elseif(strpos($user_agent, 'Nintendo') !== FALSE)
        return 'Nintendo';
    else
        return 'Unknown Platform';
}
function datefromformat($date, $input_format, $output_format="Y-m-d"){
    $date=DateTime::createFromFormat($input_format, $date);
    if(!$date instanceof DateTime || is_bool($date))
        throw new Exception("Vaya! ocurrio un problema serio en el sistema.<br/>Consulte con el Soporte Tecnico", "Conversion a DateTime is invalid", "--------");
    return $date->format($output_format);
}
function handleWarningAvise($errno, $errstr, $errfile, $errline){
	echo $errno, "<br/>", $errstr, "<br/>", $errfile, "<br/>", $errline;
	die();
	//throw new GException("Vaya! ocurrio un problema en el sistema.<br/>Consulte con el Soporte Tecnico", $errstr, 0, 1, $errfile, $errline);
}
function Ghidden($name_element, $value=''){
	echo '<input type="hidden" name="'.$name_element.'" id="'.$name_element.'" value="'.$value.'" />';
}
function GText($name_element, $value=''){
	echo '<input type="text" name="'.$name_element.'" id="'.$name_element.'" value="'.$value.'" />';
}
function timeInactividad(&$ultimoacceso){
	$ahora=date("Y-n-j H:i:s");
	$tiempo_inactivo=(strtotime($ahora)-strtotime($ultimoacceso));
	$ultimoacceso=$ahora;
	if($tiempo_inactivo>=SEGUNDOS_INACTIVOS){
		$_SESSION['autorizado']=$_SESSION['id_usuario']=$ultimoacceso=NULL;
		session_destroy();
	}
}
function num2letras($num, $fem = false, $dec = true) { 
/*! 
  @function num2letras () 
  @abstract Dado un n?mero lo devuelve escrito. 
  @param $num number - N?mero a convertir. 
  @param $fem bool - Forma femenina (true) o no (false). 
  @param $dec bool - Con decimales (true) o no (false). 
  @result string - Devuelve el n?mero escrito en letra. 
*/ 
//if (strlen($num) > 14) die("El n?mero introducido es demasiado grande"); 
	if(!is_numeric($num)){
		switch($num){
			case 'IN':
				return "Inasistente";
			break;
			case 'A':
				return "Aprobado";
			break;
			case 'EX':
				return "Exonerado";
			break;
			case 'EQ':
				return "Equivalencia";
			break;
			case 'R':
				return "Reprobado";
			break;
			default:
				return " ";
		}
		
	}
   $matuni[2]  = "dos" ; 
   $matuni[3]  = "tres" ; 
   $matuni[4]  = "cuatro"; 
   $matuni[5]  = "cinco"; 
   $matuni[6]  = "seis"; 
   $matuni[7]  = "siete"; 
   $matuni[8]  = "ocho"; 
   $matuni[9]  = "nueve"; 
   $matuni[10] = "diez"; 
   $matuni[11] = "once"; 
   $matuni[12] = "doce"; 
   $matuni[13] = "trece"; 
   $matuni[14] = "catorce"; 
   $matuni[15] = "quince"; 
   $matuni[16] = "dieciseis"; 
   $matuni[17] = "diecisiete"; 
   $matuni[18] = "dieciocho"; 
   $matuni[19] = "diecinueve"; 
   $matuni[20] = "veinte"; 
   $matunisub[2] = "dos"; 
   $matunisub[3] = "tres"; 
   $matunisub[4] = "cuatro"; 
   $matunisub[5] = "quin"; 
   $matunisub[6] = "seis"; 
   $matunisub[7] = "sete"; 
   $matunisub[8] = "ocho"; 
   $matunisub[9] = "nove"; 

   $matdec[2] = "veint"; 
   $matdec[3] = "treinta"; 
   $matdec[4] = "cuarenta"; 
   $matdec[5] = "cincuenta"; 
   $matdec[6] = "sesenta"; 
   $matdec[7] = "setenta";  
   $matdec[8] = "ochenta"; 
   $matdec[9] = "noventa"; 
   $matsub[3]  = 'mill'; 
   $matsub[5]  = 'bill'; 
   $matsub[7]  = 'mill'; 
   $matsub[9]  = 'trill'; 
   $matsub[11] = 'mill'; 
   $matsub[13] = 'bill'; 
   $matsub[15] = 'mill'; 
   $matmil[4]  = 'millones'; 
   $matmil[6]  = 'billones'; 
   $matmil[7]  = 'de billones'; 
   $matmil[8]  = 'millones de billones'; 
   $matmil[10] = 'trillones'; 
   $matmil[11] = 'de trillones'; 
   $matmil[12] = 'millones de trillones'; 
   $matmil[13] = 'de trillones'; 
   $matmil[14] = 'billones de trillones'; 
   $matmil[15] = 'de billones de trillones'; 
   $matmil[16] = 'millones de billones de trillones'; 

   $num = trim((string)@$num); 
   if ($num[0] == '-') { 
      $neg = 'menos '; 
      $num = substr($num, 1); 
   }else 
      $neg = ''; 
   while ($num[0] == '0') $num = substr($num, 1); 
   if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num; 
   $zeros = true; 
   $punt = false; 
   $ent = ''; 
   $fra = ''; 
   for ($c = 0; $c < strlen($num); $c++) { 
      $n = $num[$c]; 
      if (! (strpos(".,'''", $n) === false)) { 
         if ($punt) break; 
         else{ 
            $punt = true; 
            continue; 
         } 

      }elseif (! (strpos('0123456789', $n) === false)) { 
         if ($punt) { 
            if ($n != '0') $zeros = false; 
            $fra .= $n; 
         }else 

            $ent .= $n; 
      }else 

         break; 

   } 
   $ent = '     ' . $ent; 
   if ($dec and $fra and ! $zeros) { 
      $fin = ' con'; 
      $fin = sprintf("%s %d/100", $fin, $fra);
      /*
      for ($n = 0; $n < strlen($fra); $n++) { 
         if (($s = $fra[$n]) == '0') 
            $fin .= ' cero'; 
         elseif ($s == '1') 
            $fin .= $fem ? ' una' : ' un'; 
         else 
            $fin .= ' ' . $matuni[$s]; 
      } 
      */
   }else 
      $fin = ''; 
   if ((int)$ent === 0) return 'Cero ' . $fin; 
   $tex = ''; 
   $sub = 0; 
   $mils = 0; 
   $neutro = false; 
   while ( ($num = substr($ent, -3)) != '   ') { 
      $ent = substr($ent, 0, -3); 
      if (++$sub < 3 and $fem) { 
         $matuni[1] = 'una'; 
         $subcent = 'as'; 
      }else{ 
         $matuni[1] = $neutro ? 'un' : 'uno' ; 
         $subcent = 'os'; 
      } 
      $t = ''; 
      $n2 = substr($num, 1); 
      if ($n2 == '00') { 
      }elseif ($n2 < 21) 
         $t = ' ' . $matuni[(int)$n2]; 
      elseif ($n2 < 30) { 
         $n3 = $num[2]; 
         if ($n3 != 0) $t = 'i' . $matuni[$n3]; 
         $n2 = $num[1]; 
         $t = ' ' . $matdec[$n2] . $t; 
      }else{ 
         $n3 = $num[2]; 
         if ($n3 != 0) $t = ' y ' . $matuni[$n3]; 
         $n2 = $num[1]; 
         $t = ' ' . $matdec[$n2] . $t; 
      } 
      $n = $num[0]; 
      if ($n == 1) { 
         $t = ' ciento' . $t; 
      }elseif ($n == 5){ 
         $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t; 
      }elseif ($n != 0){ 
         $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t; 
      } 
      if ($sub == 1) { 
      }elseif (! isset($matsub[$sub])) { 
         if ($num == 1) { 
            $t = ' mil'; 
         }elseif ($num > 1){ 
            $t .= ' mil'; 
         } 
      }elseif ($num == 1) { 
         $t .= ' ' . $matsub[$sub] . '?n'; 
      }elseif ($num > 1){ 
         $t .= ' ' . $matsub[$sub] . 'ones'; 
      }   
      if ($num == '000') $mils ++; 
      elseif ($mils != 0) { 
         if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub]; 
         $mils = 0; 
      } 
      $neutro = true; 
      $tex = $t . $tex; 
   } 
   $tex = $neg . substr($tex, 1) . $fin; 
   return ucfirst($tex); 
} 

function calcular_neto($monto, $mto_impuesto, $excento){
    if($excento=='1' || $mto_impuesto==0.00)
        return $monto;
    return $monto/(1+($mto_impuesto/100));
}
function calcularedad($fec_nac){
	try{
		$hoy=new DateTime('NOW');
		$fecha_nac=new DateTime($fec_nac);
		$dif_date=$hoy->diff($fecha_nac);
		return $dif_date->y;
	}catch(Exception $e){
		echo $e->getOutMsg();
	}
}
function choque_horario($h_actual, $horas_inscribir){
	$choque=false;
	foreach($h_actual as $dia => $horas){
		if(array_key_exists($dia, $horas_inscribir)){
			foreach($horas_inscribir[$dia] as $add_hora)
				if(in_array($add_hora, $h_actual[$dia])){
					$choque=true;
					break 2;
				}	
		}
	}
	return $choque;
}
function HTTPStatus($num){
    $http = array(
        100 => 'HTTP/1.1 100 Continue',
        101 => 'HTTP/1.1 101 Switching Protocols',
		200 => 'HTTP/1.1 200 OK',
        201 => 'HTTP/1.1 201 Created',
        202 => 'HTTP/1.1 202 Accepted',
        203 => 'HTTP/1.1 203 Non-Authoritative Information',
        204 => 'HTTP/1.1 204 No Content',
        205 => 'HTTP/1.1 205 Reset Content',
        206 => 'HTTP/1.1 206 Partial Content',
        300 => 'HTTP/1.1 300 Multiple Choices',
        301 => 'HTTP/1.1 301 Moved Permanently',
        302 => 'HTTP/1.1 302 Found',
        303 => 'HTTP/1.1 303 See Other',
        304 => 'HTTP/1.1 304 Not Modified',
        305 => 'HTTP/1.1 305 Use Proxy',
        307 => 'HTTP/1.1 307 Temporary Redirect',
        400 => 'HTTP/1.1 400 Bad Request',
        401 => 'HTTP/1.1 401 Unauthorized',
        402 => 'HTTP/1.1 402 Payment Required',
        403 => 'HTTP/1.1 403 Forbidden',
        404 => 'HTTP/1.1 404 Not Found',
        405 => 'HTTP/1.1 405 Method Not Allowed',
        406 => 'HTTP/1.1 406 Not Acceptable',
        407 => 'HTTP/1.1 407 Proxy Authentication Required',
        408 => 'HTTP/1.1 408 Request Time-out',
        409 => 'HTTP/1.1 409 Conflict',
        410 => 'HTTP/1.1 410 Gone',
        411 => 'HTTP/1.1 411 Length Required',
        412 => 'HTTP/1.1 412 Precondition Failed',
        413 => 'HTTP/1.1 413 Request Entity Too Large',
        414 => 'HTTP/1.1 414 Request-URI Too Large',
        415 => 'HTTP/1.1 415 Unsupported Media Type',
        416 => 'HTTP/1.1 416 Requested Range Not Satisfiable',
        417 => 'HTTP/1.1 417 Expectation Failed',
        500 => 'HTTP/1.1 500 Internal Server Error',
        501 => 'HTTP/1.1 501 Not Implemented',
        502 => 'HTTP/1.1 502 Bad Gateway',
        503 => 'HTTP/1.1 503 Service Unavailable',
        504 => 'HTTP/1.1 504 Gateway Time-out',
        505 => 'HTTP/1.1 505 HTTP Version Not Supported'
    );
	return (array_key_exists($num, $http))?$http[$num]:$http[404];
}

function checked_json(&$cadena){
    $test=json_encode(utf8_decode($cadena));
    switch(json_last_error()){
        case JSON_ERROR_UTF8:
            $cadena=$cadena;
        break;
        default:
            $cadena=utf8_decode($cadena);
    }
}
function errorMySQL($errno){
    $msg="Error no especificado SQL";
    switch($errno){
        case 1451:
            $msg="El registro esta asociado a otra tabla como clave foranea";
        break;
    }
    return $msg;
}
?>