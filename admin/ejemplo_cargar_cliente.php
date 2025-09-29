<?php
include("../library/funcionA.php"); include("../library/funcionB.php");
include("../library/datos.php");
sesion01($ident_usuario, $nombre_usuario, $names_usuario, $apellido_usuario, $nivel_usuario, $zona_usuario, $categ_usuario);
conexiondb($Conexion);
?>
<!-- Inmplementación de JavaScript para manejar eventos en el DOM de la página Web y AJAX
Los usos del JS son manipular directamente los elementos del HTML, modificando, actualizando 
o reemplazando sus contenidos, valores o estructuras, sin recargar la página, es decir
en tiempo real. -->

<script type="text/javascript">
	// Función JS que se ejecuta cada vez que se selecciona un elemento del cmbfieldJs_span (combo box de clientes)
	// El evento que se ejecuta al seleccionar una opción del select de clientes es onchange
    function mostrar_mensaje() {
		// En la variable de Javascript id_cli se carga el valor del 'cmb_id_cli' (combo box de clientes) usando la propiedad 'value'
		// 'cmb_id_cli' es un nombre que identifica al elemento HTML como único en toda la página. Aparece como el
		// segundo parámetro de cmbfieldJs_span("spn_id_cli","cmb_id_cli",$Conexion,...)
        var id_cli = document.getElementById("cmb_id_cli").value;
		// la variable de Javascript contenido_de_cmb_id_cli se carga con el valor del contenido completo del select de clientes
		// (combo box de clientes), es decir, por ejemplo: '52956: JUDITH SOFIA MARQUEZ VALDIVIA: 74554394'. Para ello usa una
		// propiedad 'text' que a diferencia de 'value', carga todo el contenido del select, no solo su valor principal.
        var contenido_de_cmb_id_cli = document.getElementById("cmb_id_cli").options[document.getElementById("cmb_id_cli").selectedIndex].text;
		// alert() es una función JS que muestra un mensaje en una ventana emergente. En este caso concatena diversos calores
		// y los muestra como parte del ejemplo de esta función
        alert("¡Los datos del cliente se cargaron correctamente!\n\n" +
              "Id.Cliente: " + id_cli + "\n" +
              "Datos de cliente: " + contenido_de_cmb_id_cli + "\n" +
              "Fin de datos...");
		// muestraDatos_x_innerHTML() es un función JS que se ha creado para usar AJAX en el programa.
		// AJAX permite conectarse a archivos externos y obtener sus datos usando datos de envío, y 
		// recogiendo los valores obtenidos o presentados en los archivo a lo que llama.
		// En el ejemplo, 'div_clientes' representa el bloque que contiene varios <span>, 'id_cli' es
		// la variable JS que contiene el id del cliente, y 'ejemplo_buscar_datos_cliente.php' es el
		// archivo al cual se le envía el id del cliente y su resultado se colocará dentro del bloque
		// 'div_clientes'
        muestraDatos_x_innerHTML("div_clientes", id_cli, "ejemplo_buscar_datos_cliente.php");
    }
	// La función ventana_busqueda() de JS usa AJAX para actualizar (mas bien reemplazar) el objeto o elemento
	// HTML identificado por el valor de 'id', llamando al 'archivo'. En el programa se usa para filtrar, 
	// cambiar el contenido de select de clientes. Utiliza para ello la funcion JS muestraDatos_x_innerHTML()
    function ventana_busqueda(id, archivo) 
	{
		// La variable JS 'opcion' almacena el texto que se escribe en la ventana emergente que se
		// carga con el comando prompt()
		var opcion = prompt('Ingrese el dato a buscar:');
		// Si 'opcion' era diferente de vacío se envía datos como parámetros en la función JS
		// muestraDatos_x_innerHTML(). En el ejemplo, 'id' tiene el valor de 'spn_id_cli', mientras que
		// 'opcion' contiene el texto que se carga en la ventana, y finalmente 'archivo' corresponde al
		// archivo 'ejemplo_filtrar_cliente.php' que se usará con AJAX para devolver la lista de Clientes
		// filtrada.
		// La función ventana_busqueda() trabaja junto a la función boton_busqueda() de PHP que se
		// encuentra dentro de funcionA.php.
		//<button type="button" onclick="ventana_busqueda(
		if (opcion != null && opcion != '') 
		{
			muestraDatos_x_innerHTML(id, opcion, archivo);
		}
	}
    function muestraDatos_x_innerHTML(id, cadena, archivo)
	{
		// El parámetro 'id' es el identificador del objeto HTML que se usará en AJAX cuando se recibe
		// los resultados del archivo al cual se le envía el valor de 'cadena'
		// El parámetro 'cadena' es el valor que se envía al archivo, en el ejemplo contiene el id del
		// del cliente
		// El parámetro 'archivo' contiene el nombre del archivo al cual se le envía el valor de
		// 'cadena'
		if (cadena == '')
		{
			// document.getElementById(id).innerHTML es una instrucción de JS que reemplaza el contenido
			// del elemento HTML identificado por el parámetro 'id'. En getElementById(id), este parámetro
			// 'id' para el ejemplo es 'div_clientes'. 'innerHTML' es el método que reemplaza todo el
			// contenido del div con el valor asignado. En el ejemplo, si 'cadena' es vacío, entonces
			// dentro del objeto 'div_clientes' se reemplazará con vacío o en blanco, pero si 'cadena'
			// no es vacío, se reemplaza por el valor correspondiente
			document.getElementById(id).innerHTML = '';
			return;
		} 
		else 
		{
			// Esta parte contiene el algoritmo usado para AJAX.
			// En la variable 'datos' se almacena una cadena con variables y parámetros que se deben
			// enviar junto al archivo. Nótese que en 'cadena', para este ejemplo está el id del
			// cliente
			var datos='id='+cadena;
			// La variable 'contenido' va a recibir la respuesta o resultado de lo que sucede en
			// el archivo al cual se llama
			var contenido = new XMLHttpRequest();
			// contenido.onreadystatechange escucha los resultados del archivo al cual se llama, en
			// el ejemplo, para escuchar los resultados llama a una función JS 'respuesta'
			contenido.onreadystatechange = respuesta;
			// contenido.open('POST', archivo, true) es el tipo de envío que se ejecuta al llamar
			// al archivo al que se le envía los parámetros de la variable 'datos'. Es necesario
			// que el archivo que recibe los valores de 'datos' lo lea usando $_POST
			contenido.open('POST', archivo, true);
			// contenido.setRequestHeader('Content-type'...) son parametros para codificación al
			// enviar los 'datos'
			contenido.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			// contenido.send(datos) es la instrucción que realmente envía los datos de la variable
			// JS 'datos' al archivo, que en el ejemplo es 'ejemplo_buscar_datos_cliente.php', lo
			// hace usando el método 'send'.
			contenido.send(datos);
			// La función respuesta() de JS evalua los resultados o respuesta del archivo 
			// 'ejemplo_buscar_datos_cliente.php' a donde se envió como parámetros los valores dentro
			// de la variable JS 'datos'. Si la comunicación o estado fue correcta, verificado con
			// el método 'readyState' igual a 4, y método 'status' igual a 200, se procede a
			// reemplazar el contenido del objeto o elemento HTML indicado
			function respuesta() 
			{
				if (contenido.readyState == 4 && contenido.status == 200) 
				{
					// document.getElementById(id).innerHTML va a reemplazar con el resultado
					// obtenido del archivo 'ejemplo_buscar_datos_cliente.php' en el objeto
					// o elemento HTML indicado con el identificado 'id' que en el ejemplo 
					// es 'div_clientes'
					document.getElementById(id).innerHTML = contenido.responseText;
				}
			};
		}
	}
</script>
<!DOCTYPE HTML>
<html>
	<head><?php pestanna($nombre_usuario, $nivel_usuario, $ident_usuario, $zona_usuario, $categ_usuario, "Registro de Ventas(TMP)");?></head>
	<body>
        <center>
        <h2>Venta Nueva</h2>
        <div>
        <form style=" background-color:rgba(229, 215, 215, 1); width:80%; text-align:left;" action="" method="post" name="form1" id="form1">
            <span>Clientes:<?php cmbfieldJs_span("spn_id_cli","cmb_id_cli",$Conexion,"SELECT * FROM clientes ORDER BY id_cli DESC LIMIT 100","","onchange=mostrar_mensaje();","id_cli","nom_rzs_cli","dni_ruc_cli"); boton_busqueda("spn_id_cli", "ejemplo_filtrar_cliente.php"); sl(1);?></span>
            <div id="div_clientes">
                <span>Id.Cliente:</span><input type="text" name="txt_id_cli" id="txt_id_cli" value="" style="width:50px;"><br>
                <span>Nombre/Razón Social:</span><input type="text" name="txt_nom_rzs_cli" id="txt_nom_rzs_cli" value="" style="width:300px;"><br>
                <span>DNI/RUC:</span><input type="text" name="txt_dni_ruc_cli" id="txt_dni_ruc_cli" value="" style="width:150px;"><br>
                <span>Dirección:</span><input type="text" name="txt_direcc_cli" id="txt_direcc_cli" value="" style="width:300px;"><br>
                <span>Teléfono:</span><input type="text" name="txt_telcel_cli" id="txt_telcel_cli" value="" style="width:150px;"><br>
            </div>
        </form>
        </div>
        </center>
  </body>
</html>