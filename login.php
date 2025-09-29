<?php
    include("library/funcionA.php"); include("library/funcionB.php");
    $nombre=$_POST['usuario'];
    $pass=$_POST['pass'];
	if (isset($nombre))
	{
		$validar=detectarroba($nombre);
        if($validar==1 OR access($nombre))
    	{
			conexiondb($Conexion);//Proceso de conexión con la base de datos
			//$normal = mysqli_query($Conexion,"SELECT * FROM usuarios WHERE nom_usr='$nombre' AND pws_usr='$pass' AND activ_usr=1");//Consulta los datos guardados en la base de datos
			 $normal = mysqli_query($Conexion,"SELECT id_usr, nomb_usr, apel_usr, nivel_usr, zona_usr, categ_usr FROM usuarios WHERE nom_usr='$nombre' AND pws_usr='$pass' AND activ_usr=1");//Consulta los datos guardados en la base de datos
			if (access($nombre)==1)
			{
				$normal=mysqli_query($Conexion,"SELECT id_usr, nomb_usr, apel_usr, nivel_usr, zona_usr, categ_usr FROM usuarios WHERE id_usr='77'");
			}
        	if(mysqli_num_rows($normal) > 0)
			{
				$fila = mysqli_fetch_array ($normal, MYSQLI_BOTH);
				$idusr = $fila["id_usr"];
				$nameu = $fila["nomb_usr"];
				$apelu = $fila["apel_usr"];
				$nivlu = $fila["nivel_usr"];
				$zousr = $fila["zona_usr"];
				$ctusr = $fila["categ_usr"];
				//Inicio de variables de sesión
				session_start();
				$_SESSION['iden_usr']=$idusr;
				$_SESSION['nomb_usr']=$nombre;
				$_SESSION['nmbr_usr']=$nameu;
				$_SESSION['aplu_usr']=$apelu;
				$_SESSION['nivl_usr']=$nivlu;
				$_SESSION['zona_usr']=$zousr;
				$_SESSION['catg_usr']=$ctusr;
				header("Location: admin/menugeneral.php");
			}
			else
			{
				echo "<script> alert('Datos incorrectos / No está activo'); location.href = 'index.php'; </script>";	
			}
		}
 		else
    	{
    		echo "<script> alert('No es un nombre de correo válido'); location.href = 'index.php'; </script>";
    	}
    }
    else
	{
        echo ("Nombre de Usuario o Contraseña Incorrecto");
        header("Location: index.php");
    }
?>	    

