<!DOCTYPE html>
<html>
<?php
// Ubicación y movimiento de archivos *.pdf, *.xml y R-*.zip
//Para resolver el error Fatal error:  Maximum execution time of 30 seconds exceeded in
//modificar en el archivo php.ini lo siguiente: max_execution_time=30 a 120
echo "<pre style='font-family:Consolas;'>";
echo "Mover archivos<br>";
echo "--------------<br>";
//$ruta_original=str_replace('\\', '/', getcwd());
$ruta_original="datasunat/";
$ruta_original=verificar_ruta($ruta_original);
//$meses=array("01","02","03","04","05","06","07","08","09","10","11","12");
$meses=array("01","02","03","04");
foreach ($meses as $mes)
{
	$ruta_destino=verificar_ruta($ruta_original."2025/".$mes);
  	mover_lista_archivos_($ruta_original,$ruta_destino,"none","2025",$mes);
  	echo $ruta_destino."<br>";
}
// echo $ruta_original."<br>";
// echo $ruta_destino."<br>";
// obtener_estructura_directorios($ruta_original);
echo "</pre>";
?>
</html>
<?php
function mover_archivo($origen,$destino,$archivo)
{
	if (file_exists($origen))
	{
		if (file_exists($destino))
		{
			if ($origen!=$destino)
			{
				if ($archivo!="index.php")
				{
					if (tipo_archivo($archivo)!="ninguno")
					{
						$resultado = rename($origen.$archivo, $destino.$archivo);
					}
					else
					{
						echo "El tipo de archivo corresponde a una carpeta o ningun archivo.<br>";
					}
				}
				else
				{
					echo "El archivo no se puede mover porque es index.php.<br>";
				}					
			}
			else
			{
				echo "La carpeta origen y destino son iguales.<br>";
			}	
		}
		else
		{
			echo "La carpeta destino no existe.<br>";
		}
	} 
	else
	{
		echo "La carpeta origen no existe.<br>";
	} 
}
function mover_lista_archivos_($ruta_original,$ruta_destino,$tipo_archivo="none",$ann="0000",$mes="00")
{
    if (is_dir($ruta_original))
	{
		if (!file_exists($ruta_destino))
		{
			mkdir($ruta_destino, 0777, true);
		}
        $gestor = opendir($ruta_original);
        while (($archivo = readdir($gestor)) !== false) 
		{
			$ruta_archivo_origen=substr($ruta_original,-1)=="/" ? $ruta_original.$archivo : $ruta_original."/".$archivo;
			$ruta_archivo_destino=substr($ruta_destino,-1)=="/" ? $ruta_destino.$archivo : $ruta_destino."/".$archivo;
			//echo $ruta_archivo_origen." - ".$ruta_archivo_destino."<br>";
            if ($archivo != "." && $archivo != "..")
			{
				//$currentModified = filectime($ruta_archivo_origen);
				//filemtime Obtiene el momento de la última modificación de un archivo
				$currentModified = filemtime($ruta_archivo_origen);
				$fmes=date("m",$currentModified);
				$fann=date("Y",$currentModified);
				$tipo_de_archivo=tipo_archivo($archivo);
				//echo $fann." - ".$fmes." - ".$tipo_de_archivo."<br>";
				if ($tipo_archivo=="none")
				{
					if ($ann=="0000")
					{
						if ($mes=="00")
						{
							// echo $ruta_original."     ".$ruta_destino."<br>";
							mover_archivo($ruta_original,$ruta_destino,$archivo);
						}
						elseif($mes==$fmes)
						{
							// echo $ruta_original."     ".$ruta_destino."<br>";
							mover_archivo($ruta_original,$ruta_destino,$archivo);
						}
					}
					elseif ($ann==$fann)
					{
						if ($mes=="00")
						{
							// echo $ruta_original."     ".$ruta_destino."<br>";
							mover_archivo($ruta_original,$ruta_destino,$archivo);
						}
						elseif($mes==$fmes)
						{
							// echo $ruta_original."     ".$ruta_destino."<br>";
							mover_archivo($ruta_original,$ruta_destino,$archivo);
						}
					}
				}
				elseif($tipo_archivo==$tipo_de_archivo)
				{
					if ($ann=="0000")
					{
						if ($mes=="00")
						{
							// echo $ruta_original."     ".$ruta_destino."<br>";
							mover_archivo($ruta_original,$ruta_destino,$archivo);
						}
						elseif($mes==$fmes)
						{
							// echo $ruta_original."     ".$ruta_destino."<br>";
							mover_archivo($ruta_original,$ruta_destino,$archivo);
						}
					}
					elseif ($ann==$fann)
					{
						if ($mes=="00")
						{
							// echo $ruta_original."     ".$ruta_destino."<br>";
							mover_archivo($ruta_original,$ruta_destino,$archivo);
						}
						elseif($mes==$fmes)
						{
							// echo $ruta_original."     ".$ruta_destino."<br>";
							mover_archivo($ruta_original,$ruta_destino,$archivo);
						}
					}
				}
            }
        }
        closedir($gestor);
    } 
	else
	{
        echo "No es una ruta de origen de directorio valida.<br/>";
    }
}
function quitar_espacios($cadenaOriginal)
{
	$cadenaBuscar=" ";
	$cadenaReemplazar="";
	return str_replace($cadenaBuscar, $cadenaReemplazar, $cadenaOriginal); 
}
function añadir_slash($cadena)
{
	$ultimo_caracter=substr($cadena, -1);
	if ($ultimo_caracter!="/")
	{
		return $cadena."/";
	}
	else
	{
		return $cadena;
	}
}
function verificar_ruta($ruta_original)
{
	$probar_quitar_espacios=quitar_espacios($ruta_original);
	$nueva_cadena=añadir_slash($probar_quitar_espacios);
	return $nueva_cadena;
}
function tipo_archivo($archivo)
{
	$pos=strpos($archivo,".");
	if ($pos===false)
	{
		return "ninguno";
	} 
	else 
	{
		return substr($archivo,$pos+1,5);
	}
}
function obtener_estructura_directorios($ruta)
{
	if (is_dir($ruta))
	{
        	$gestor = opendir($ruta);
	        while (($archivo = readdir($gestor)) !== false) 
		{
			$ruta_completa=substr($ruta,-1)=="/" ? $ruta.$archivo : $ruta."/".$archivo;
			if ($archivo != "." && $archivo != "..")
			{
	                // Si es un directorio se recorre recursivamente
	                // if (is_dir($ruta_completa))
					// {
	                    // echo "<li>" . $archivo . "</li>";
	                    // obtener_estructura_directorios($ruta_completa);
	                // } 
					// else
					// {
						// $currentModified = filectime($ruta_completa);
						// $fecha=date("d-m-Y",$currentModified);
	                    // echo "<li>" . $archivo ."[".$fecha."]</li>";
	                // }
				$currentModified = filectime($ruta_completa);
				$fecha=date("d-m-Y",$currentModified);
				$dia=date("d",$currentModified);
				$mes=date("m",$currentModified);
				$ann=date("Y",$currentModified);
				$tipo_de_archivo=tipo_archivo($archivo);
				if ($ann=="2020")
				{
					echo $ruta_completa."     ".$fecha."<br>";
				}
	
			}
        	}
        	closedir($gestor);
	} 
	else
	{
	        echo "No es una ruta de directorio valida.<br>";
	}
}
?>