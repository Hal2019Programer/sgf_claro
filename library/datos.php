<?php
//Datos par archivo plano: cabecera (factura o boleta de venta electronica)
class ap_bvfac_cabecera //.CAB
{
	public $tipo_operacion; //1. Catalogo 51: CONSTANTE > codigo=0101(Venta Interna)
	public $fecha_emision; //2. regvtacaja.fechaemi_rvi
	public $hora_emision; //3. regvtacaja.horaemi_rvc
	public $fecha_vencimiento; //4. regvtacaja.fechaven_rvi
	public $cod_domicil_fiscal; //5. regvtacaja.id_undc:undcomerc.codfiscal_undc
	public $tipo_docum_usuario; //6. Catalogo 6:regvtacaja.id_tipdoc:tipodocident.cod_tipdoc
	public $num_doc_ident_usuario; //7. regvtacaja.id_cli:clientes.dni_ruc_cli
	public $nomb_razsoc_usuario; //8. regvtacaja.id_cli:clientes.nom_rzs_cli
	public $tipo_moneda; //9. Catalogo 2:regventas.id_tipmnd:tipomoned.cod_tipmnd
	public $sumatoria_tributos; //10. regvtacaja.igv_rvi
	public $total_valor_venta; //11. regvtacaja.baseimpopgrv_rvi
	public $total_precio_venta; //12. regvtacaja.importetot_rvi
	public $total_descuentos; //13. CONSTANTE > 0.00
	public $sumatoria_otros_cargos; //14. CONSTANTE > 0.00
	public $total_anticipos; //15. CONSTANTE > 0.00
	public $importe_total; //16. $total_precio_venta - $total_descuentos + $sumatoria_otros_cargos - $total_anticipos
	public $version_UBL; //17. CONSTANTE > 2.1
	public $custom_docum; //18. CONSTANTE > 2.0
}
class ap_bvfac_detalles //.DET
{
	public $cod_unidad_med; //1. Catalogo 3:regventa.id_udint:undinternac.cod_udint
	public $cant_unidad_item; //2. CONSTANTE > 1 (considerado por que los productos se venden 1 a 1)
	public $cod_product; //3. regventas.id_pro (convertido en codigo de producto de 10 caracteres)
	public $cod_prod_sunat; //4. Catalogo 25:-
	public $descrip_detalle; //5. regventas.id_pro:productos.abrv_pro
	public $valor_unitario; //6. regventas.baseimpopgrv_rvi
	public $sumatoria_tributos_item; //7. $monto_igv_item
	//---------------------------------- tributos IGV -----------------------------------
	public $cod_tipos_tributos_igv; //8. Catalogo 5: CONSTANTE > codigo=1000 (IGV Impuesto General a las Ventas)
	public $monto_igv_item; //9. regventas.igv_rvi
	public $base_imponible_igv_item; //10. regventas.baseimpopgrv_rvi
	public $nombre_tributo_item; //11. Catalogo 5: CONSTANTE > Nombre=IGV
	public $cod_tipo_tributo_item; //12.Catalogo 5: CONSTANTE > codigo=1000
	public $afectacion_igv_item; //13. Catalogo 7: CONSTANTE > codigo=10 (Gravado - Operacion Onerosa)
	public $porcentaje_igv; //14. CONSTANTE > 18.00 (valor fijo)
	//---------------------------------- tributos ISC  ----------------------------------
	public $cod_tipos_tributos_isc; //15. Catalogo 5:-
	public $monto_isc_item; //16. CONSTANTE > 0.00 (valor cero ya que la empresa no esta afecta al ISC)
	public $base_imponible_isc_item; //17. CONSTANTE > 0.00
	public $nombre_tributisc_item; //18. Catalogo 5.name:-
	public $cod_tipo_tributisc_item; //19. Catalogo 5:-
	public $tipo_sistema_isc; //20. Catalogo 8:-
	public $porcentaje_isc; //21. CONSTANTE > 0.00
	//---------------------------------- Otros tributos ---------------------------------
	public $cod_tipos_otrostrib; //22. Catalogo 5:-
	public $monto_otrostrib_item; //23. CONSTANTE > 0.00 (valor cero ya que la empresa no tiene otros tributos)
	public $base_imponible_otrostrib_item; //24. CONSTANTE > 0.00
	public $nombre_otrostrib_item; //25. Catalogo 5.name:-
	public $cod_otrostrib_item; //26. Catalogo 5:-
	public $porcentaje_otrostrib; //27. CONSTANTE > 0.00
	////----------------------------//---------------------------------------------------
	public $precio_vta_unitario; //28. $valor_venta_item + $sumatoria_tributos_item
	public $valor_venta_item; //29. $valor_unitario * $cant_unidad_item
	public $valor_referencial_unitario; //30. - (Se usa el guion para indicar que este campo no se usa)
}
class ap_bvfac_tributos_generales //.TRI
{
	public $identif_tributi; //1. Catalogo 5.Id: CONSTANTE > codigo=1000
	public $nombre_tributo; //2. Catalogo 5.name: CONSTANTE > nombre=IGV
	public $cod_tributo; //3. Catalogo 5: CONSTANTE > codigo=1000
	public $base_imponible; //4. regvtacaja.baseimpopgrv_rvi
	public $monto_tributo_item; //5. regvtacaja.igv_rvi
}
class ap_bvfac_leyendas //.LEY
{
	public $cod_leyenda; //1. Catalogo 15: CONSTANTE > codigo=1000
	public $descrip_leyenda; //2. Descripcion de regvtacaja.importetot_rvi en letras (funcion que convierte a mayusculas)
}
class ap_bvfac_docum_relacionados //.REL (Documentos indicados que aparecen relacionados con el comprobante)
{
	public $indic_doc_relacionado; //1. 1:Guia, 2:Anticipo, 3:Orden de compra, 98:Documentos afectados por nota de credito/debito, 99:Otros
	public $num_identif_anticip; //2. Solo caso 2
	public $tipo_doc_relacionado; //3. Relacionado:Guia/Documento, Afectado:Catalogo 1, Anticipo u Otros:Catalogo 12
	public $numero_doc_relacionado; //4. Serie-Numero
	public $tipo_docemisor_docrelacionado; //5. Catalogo 5
	public $num_docemisor_docrelacionado; //6. Serie-Numero
	public $monto_doc_relacionado; //7. Monto en S/
}
class ap_bvfac_adicionales_cabecera //.ACA
{
	public $ctabaconaciondetraccion; //1. -
	public $cod_prod_sujeto_detraccion; //2. Catalogo 54:-
	public $porcentaje_detraccion; //3. -
	public $monto_detraccion; //4. -
	public $medio_pago; //5. Catalogo 59:-
	//------------------------ Datos adicionales de Cliente ------------------------
	public $cod_pais_cliente; //6. Catalogo 4: CONSTANTE > PE
	public $cod_ubigeo_cliente; //7. Catalogo 13:-
	public $direccion_cliente; //8. regvtacaja.id_cli:clientes.direcc_cli
	//------------------------------------------------------------------------------
	public $cod_pais_entrega; //9. Catalogo 4:-
	public $cod_ubigeo_clientrega; //10. Catalogo 13:-
	public $direccion_entrega; //11. -
}
class ap_bvfac_adicionales_detalle //.ADE
{
	public $linea_item; //1. Id, linea o fila del item
	public $propiedad_nombre_item; //2. Catalogo 55.Descripcion
	public $propiedad_cod_item; //3. Catalogo 55.Id
	public $propiedad_valor_item; //4. Monto S/
	public $propiedad_cod_bien_item; //5. Catalogo 54
	public $propiedad_fecha_inicio_item; //6. año-mes-dia
	public $propiedad_hora_inicio_item; //7. hora-min-seg
	public $propiedad_fecha_fin_item; //8. año-mes-dia
	public $propiedad_duracion_dias_item; //9. dias
	public $variable_item_tipo; //10. true/false
	public $variable_item_cod_tipo; //11. Catalogo 53
	public $variable_item_porcentaje; //12. 0.00
	public $variable_item_moneda_monto; //13. Catalogo 2:PEN/USD/EUR
	public $variable_item_monto; //14. S/
	public $variable_item_moneda_base_imponible; //15. Catalogo 2:PEN/USD/EUR
	public $variable_item_base_imponible; //16. S/
}
class ap_bvfac_adicionales_cabecera_variable //.ACV
{
	public $varglob_tipo; //1. true/false
	public $varglob_cod_tipo; //2. Catalogo 53
	public $varglob_porcentaje; //3. 0.00
	public $varglob_moneda_monto; //4. Catalogo 2
	public $varglob_monto; //5. S/
	public $varglob_moneda_base_imponible; //6. Catalogo 2
	public $varglob_base_imponible; //7. S/
}
class ap_bvfac_nota_credito_debito //.NOT
{
	public $varglob_tipo; //1. true/false
	//...
}
//Datos obtenidos de tabla regvtacaja: cabecera de comprobantes de pago
class regvtacaja
{
	public $id_rvc;  
	public $id_cli;  
	public $tipopla_rvi;
	public $id_pla;
	public $fechaemi_rvi;
	public $horaemi_rvi;
	public $fechaven_rvi;
	public $codcpg_rvi;
	public $tipodoccp_rvi;
	public $seriecp_rvi;
	public $numcp_rvi;
	public $descrip_rvi;
	public $formapago_rvi;
	public $baseimpopgrv_rvi;
	public $baseimpopngrv_rvi;
	public $isc_rvi;
	public $igv_rvi;
	public $importetot_rvi;
	public $id_usr;
	public $rgpag_rvc;
	public $zona_rvi;
	public $estado_rvc;
	public $fechapag_rvc;
	public $id_usr_anula;
	public $causanul_rvc;
	public $cee_rvc;
	public $causamant_rvc;
	public $id_ubi;
	public $id_undc;
	public $id_tipcmp;
	public $id_empe;
	public $id_tipdoc;
	public $id_elad;
	//MODIFICADO POR JUAN (09-06-2019) PARA INLCUIR COMPROBANTE ELECTRONICO
	public $nombarch_rvc;
	public $codigocdr_rvc;
	public $mensajecdr_rvc;
	
	
	public function consulta_registro_regvtacaja(&$o,$conx,$id,&$filas)
	{
		$result=mysqli_query($conx,"SELECT * FROM regvtacaja WHERE id_rvc='$id'") or die ("Error al traer los datos de regvtacaja.");
		$filas=mysqli_num_rows($result);
		if($filas>0)
		{
			$r=mysqli_fetch_array($result, MYSQLI_ASSOC);
			$o->id_rvc=$r["id_rvc"];
			$o->id_cli=$r["id_cli"];
			$o->tipopla_rvi=$r["tipopla_rvi"];
			$o->id_pla=$r["id_pla"];
			$o->fechaemi_rvi=$r["fechaemi_rvi"];
			$o->horaemi_rvi=$r["horaemi_rvi"];
			$o->fechaven_rvi=$r["fechaven_rvi"];
			$o->codcpg_rvi=$r["codcpg_rvi"];
			$o->tipodoccp_rvi=$r["tipodoccp_rvi"];
			$o->seriecp_rvi=$r["seriecp_rvi"];
			$o->numcp_rvi=$r["numcp_rvi"];
			$o->descrip_rvi=$r["descrip_rvi"];
			$o->formapago_rvi=$r["formapago_rvi"];
			$o->baseimpopgrv_rvi=$r["baseimpopgrv_rvi"];
			$o->baseimpopngrv_rvi=$r["baseimpopngrv_rvi"];
			$o->isc_rvi=$r["isc_rvi"];
			$o->igv_rvi=$r["igv_rvi"];
			$o->importetot_rvi=$r["importetot_rvi"];
			$o->id_usr=$r["id_usr"];
			$o->rgpag_rvc=$r["rgpag_rvc"];
			$o->zona_rvi=$r["zona_rvi"];
			$o->estado_rvc=$r["estado_rvc"];
			$o->fechapag_rvc=$r["fechapag_rvc"];
			$o->id_usr_anula=$r["id_usr_anula"];
			$o->causanul_rvc=$r["causanul_rvc"];
			$o->cee_rvc=$r["cee_rvc"];
			$o->causamant_rvc=$r["causamant_rvc"];
			$o->id_ubi=$r["id_ubi"];
			$o->id_undc=$r["id_undc"];
			$o->id_tipcmp=$r["id_tipcmp"];
			$o->id_empe=$r["id_empe"];
			$o->id_tipdoc=$r["id_tipdoc"];
			$o->id_elad=$r["id_elad"];
			//MODIFICADO POR JUAN (09-06-2019) PARA INLCUIR COMPROBANTE ELECTRONICO
			$o->nombarch_rvc=$r["nombarch_rvc"];
			$o->codigocdr_rvc=$r["codigocdr_rvc"];
			$o->mensajecdr_rvc=$r["mensajecdr_rvc"];
		}
	}
}
//Datos obtenidos de tabla regventas: detalle de los comprobantes de pago
class regventas
{
	public $id_rvi;  
	public $id_cli;  
	public $id_pro;
	public $tipopla_rvi;
	public $id_pla;
	public $fechaemi_rvi;
	public $fechaven_rvi;
	public $tipodoccp_rvi;
	public $seriecp_rvi;
	public $numcp_rvi;
	public $descrip_rvi;
	public $formapago_rvi;
	public $baseimpopgrv_rvi;
	public $baseimpopngrv_rvi;
	public $isc_rvi;
	public $igv_rvi;
	public $importetot_rvi;
	public $id_usr;
	public $numcont_rvi;
	public $numcel_rvi;
	public $codpqt_rvi;
	public $codcpg_rvi;
	public $rgpag_rvi;
	public $zona_rvi;
	public $imprecef_rvi;
	public $id_udint;
	public $id_tipmnd;
	public $id_tipisc;
	public $id_cdaf;
	public $id_tipopr;
	
	public function consulta_registro_regventas($o,$conx,$id,&$filas)
	{
		$result=mysqli_query($conx,"SELECT * FROM regventas WHERE id_rvi='$id'") or die ("Error al traer los datos de regventas.");
		$filas=mysqli_num_rows($result);
		if($filas>0)
		{
			$r=mysqli_fetch_array($result, MYSQLI_ASSOC);
			$o->id_rvi=$r["id_rvi"];
			$o->id_cli=$r["id_cli"];
			$o->id_pro=$r["id_pro"];
			$o->tipopla_rvi=$r["tipopla_rvi"];
			$o->id_pla=$r["id_pla"];
			$o->fechaemi_rvi=$r["fechaemi_rvi"];
			$o->fechaven_rvi=$r["fechaven_rvi"];
			$o->tipodoccp_rvi=$r["tipodoccp_rvi"];
			$o->seriecp_rvi=$r["seriecp_rvi"];
			$o->numcp_rvi=$r["numcp_rvi"];
			$o->descrip_rvi=$r["descrip_rvi"];
			$o->formapago_rvi=$r["formapago_rvi"];
			$o->baseimpopgrv_rvi=$r["baseimpopgrv_rvi"];
			$o->baseimpopngrv_rvi=$r["baseimpopngrv_rvi"];
			$o->isc_rvi=$r["isc_rvi"];
			$o->igv_rvi=$r["igv_rvi"];
			$o->importetot_rvi=$r["importetot_rvi"];
			$o->id_usr=$r["id_usr"];
			$o->numcont_rvi=$r["numcont_rvi"];
			$o->numcel_rvi=$r["numcel_rvi"];
			$o->codpqt_rvi=$r["codpqt_rvi"];
			$o->codcpg_rvi=$r["codcpg_rvi"];
			$o->rgpag_rvc=$r["rgpag_rvc"];
			$o->zona_rvi=$r["zona_rvi"];
			$o->imprecef_rvi=$r["imprecef_rvi"];
			$o->id_udint=$r["id_udint"];
			$o->id_tipmnd=$r["id_tipmnd"];
			$o->id_tipisc=$r["id_tipisc"];
			$o->id_cdaf=$r["id_cdaf"];
			$o->id_tipopr=$r["id_tipopr"];
		}
	}
}
//Datos de tabla rgvtatmp: temporal de detalle de ventas
class rgvtatmp
{
	public $id_rvi;  
	public $id_cli;  
	public $id_pro;
	public $tipopla_rvi;
	public $id_pla;
	public $fechaemi_rvi;
	public $fechaven_rvi;
	public $tipodoccp_rvi;
	public $seriecp_rvi;
	public $numcp_rvi;
	public $descrip_rvi;
	public $formapago_rvi;
	public $baseimpopgrv_rvi;
	public $baseimpopngrv_rvi;
	public $isc_rvi;
	public $igv_rvi;
	public $importetot_rvi;
	public $id_usr;
	public $numcont_rvi;
	public $numcel_rvi;
	public $codpqt_rvi;
	public $codcpg_rvi;
	public $rgpag_rvc;
	public $zona_rvi;
	public $imprecef_rvi;
	
	public function consulta_registro_x_fila($o,$r)
	{
		//$r=mysqli_fetch_array($result, MYSQLI_ASSOC);
		$o->id_rvi=$r["id_rvi"];
		$o->id_cli=$r["id_cli"];
		$o->id_pro=$r["id_pro"];
		$o->tipopla_rvi=$r["tipopla_rvi"];
		$o->id_pla=$r["id_pla"];
		$o->fechaemi_rvi=$r["fechaemi_rvi"];
		$o->fechaven_rvi=$r["fechaven_rvi"];
		$o->tipodoccp_rvi=$r["tipodoccp_rvi"];
		$o->seriecp_rvi=$r["seriecp_rvi"];
		$o->numcp_rvi=$r["numcp_rvi"];
		$o->descrip_rvi=$r["descrip_rvi"];
		$o->formapago_rvi=$r["formapago_rvi"];
		$o->baseimpopgrv_rvi=$r["baseimpopgrv_rvi"];
		$o->baseimpopngrv_rvi=$r["baseimpopngrv_rvi"];
		$o->isc_rvi=$r["isc_rvi"];
		$o->igv_rvi=$r["igv_rvi"];
		$o->importetot_rvi=$r["importetot_rvi"];
		$o->id_usr=$r["id_usr"];
		$o->numcont_rvi=$r["numcont_rvi"];
		$o->numcel_rvi=$r["numcel_rvi"];
		$o->codpqt_rvi=$r["codpqt_rvi"];
		$o->codcpg_rvi=$r["codcpg_rvi"];
		$o->rgpag_rvc=$r["rgpag_rvc"];
		$o->zona_rvi=$r["zona_rvi"];
		$o->imprecef_rvi=$r["imprecef_rvi"];
	}
}
//Datos de tabla tipo de documento: boleta de venta o factura
class tipocomprobante
{
	public $inicial;
	public $codigo;
	public function tipo_comprobante(&$o,$tipo,&$sit)
	{
		if ($tipo=="Boleta de venta")
		{
			$o->codigo="03";
			$o->inicial="B";
			$sit="1";
		}
		if ($tipo=="Factura")
		{
			$o->codigo="01";
			$o->inicial="F";
			$sit="1";
		}
		if ($tipo<>"Boleta de venta" AND $tipo<>"Factura")
		{
			$o->codigo="00";
			$o->inicial="A";
			$sit="0";
		}
	}
}
//Datos de tabla cliente: datos en detalle del cliente
class clientes
{
	public $id_cli;  
	public $nom_rzs_cli;  
	public $dni_ruc_cli;
	public $tlfcel_cli;
	public $direcc_cli;
	public $lugar_Cli;
	public $prscont_cli;
	public $tlfcel_prscont_cli;
	public $fechreg_cli;
	public $id_usr;
	public $tipo_cli;
	public $zona_cli;
	public $id_tipdoc;
	
	public function consulta_registro_cliente(&$o,$conx,$id)
	{
		$sql=mysqli_query($conx,"SELECT * FROM clientes WHERE id_cli='$id'") or die ("Error al traer los datos de clientes.");
		$filas=mysqli_num_rows($sql);
		if($filas>0)
		{
			$r=mysqli_fetch_array($sql, MYSQLI_ASSOC);
			$o->id_cli=$r["id_cli"];
			$o->nom_rzs_cli=$r["nom_rzs_cli"];
			$o->dni_ruc_cli=$r["dni_ruc_cli"];
			$o->tlfcel_cli=$r["tlfcel_cli"];
			$o->direcc_cli=$r["direcc_cli"];
			$o->lugar_Cli=$r["lugar_cli"];
			$o->prscont_cli=$r["prscont_cli"];
			$o->tlfcel_prscont_cli=$r["tlfcel_prscont_cli"];
			$o->fechreg_cli=$r["fechreg_cli"];
			$o->id_usr=$r["id_usr"];
			$o->tipo_cli=$r["tipo_cli"];
			$o->zona_cli=$r["zona_cli"];
			$o->id_tipdoc=$r["id_tipdoc"];
		}
		else
		{
			mensaje("No se obtuvo datos del cliente.");
		}
	}
}
//Datos obtenidos de tabla emisor (empresa emisora del comprobante)
class empemisor
{
	public $id_empe;  
	public $nomb_empe;  
	public $nmbc_empe;
	public $ndoc_empe;
	public $id_ubi;
	public $dir_empe;
	public $urb_empe;
	public $dist_empe;
	public $prov_empe;
	public $region_empe;
	public $codpais_empe;
	
	public function consulta_registro_emisor(&$o,$conx,$id)
	{
		$sql=mysqli_query($conx,"SELECT * FROM empemisor WHERE id_empe='$id'") or die ("Error al traer los datos de empresa emisora.");
		$filas=mysqli_num_rows($sql);
		if($filas>0)
		{
			$r=mysqli_fetch_array($sql, MYSQLI_ASSOC);
			$o->id_empe=$r["id_empe"];
			$o->nomb_empe=$r["nomb_empe"];
			$o->nmbc_empe=$r["nmbc_empe"];
			$o->ndoc_empe=$r["ndoc_empe"];
			$o->id_ubi=$r["id_ubi"];
			$o->dir_empe=$r["dir_empe"];
			$o->urb_empe=$r["urb_empe"];
			$o->dist_empe=$r["dist_empe"];
			$o->prov_empe=$r["prov_empe"];
			$o->region_empe=$r["region_empe"];
			$o->codpais_empe=$r["codpais_empe"];
		}
		else
		{
			mensaje("No se obtuvo datos de empresa emisora.");
		}
	}
}
//Datos del cliente requeridos por SUNAT
class vClient
{
	public $tipodoc;
	public $numdoc;
	public $rznsocial;
	public $direccion;
}
//Datos de ubicación y dirección requeridos por SUNAT
class vAddress
{
	public $ubigeo;
	public $departamento;
	public $provincia;
	public $distrito;
	public $urbanizacion;
	public $direccion;
}
//Datos de la empresa emisora requeridos por SUNAT
class vCompany
{
	public $ruc;
	public $razonsocial;
	public $nombrecomercial;
	public $address;
}
//Datos de cabecera de comprobante requeridos por SUNAT
class vInvoice
{
	public $tipodoc;
	public $serie;
	public $correlativo;
	public $fechaemision;
	public $tipomoneda;
	public $client;
	public $mtoopergravadas;
	public $mtooperexoneradas;
	public $mtooperinafectas;
	public $mtoigv;
	public $mtoimpventa;
	public $company;
}
//Datos de detalle de comprobante requeridos por SUNAT
class vSaleDetail
{
	public $codproducto;
	public $codunidadmedida;
	public $ctdunidaditem;
	public $desitem;
	public $descuento;
	public $mtoigvitem;
	public $tipoafeigv;
	public $mtovalorventa;
	public $mtovalorunitario;
	public $mtopreciounitario;
}
//Datos de leyenda de comprobante requeridos por SUNAT
class vLegend
{
	public $code;
	public $value;
}
class conteo_zonas
{
	//public $lista_zona=["Satipo", "Pichanaki", "La Merced", "Huancayo", "Huancayo2", "Huancayo3", "RealPlaza","VentaCampo"];
	//public $lista_zona=["JUNCD05","JUNDL39","JUNDL43","PRE_DL39","PRE_DL43","JUNCD12","Almacen1","Almacen2","Almacen3","Almacen4","Almacen5","JUNDA29"];
	public $lista_zona=["PDV_JXU4"];
	public $zona;
	public $cuenta;
	public $monto;
	public function inicializar_lista(&$o,$lista)
	{
		for ($l=0; $l<count($lista); $l++) 
		{ 
			$ob=new conteo_zonas;
			$ob->zona=$lista[$l];
			$ob->cuenta=0;
			$ob->monto=0;
			$o[$l]=$ob;
		}
	}
	public function contar_a_lista(&$o,$lista,$zona,$im_tot)
	{
		for ($l=0; $l<count($lista); $l++)
		{ 
			if ($zona==$lista[$l]) 
			{ 
				$o[$l]->cuenta++; 
				$o[$l]->monto=$o[$l]->monto+$im_tot; 
			}
		}
	}
	public function mostrar_lista($o,$lista)
	{
		for ($l=0; $l<count($lista); $l++)
		{
			$anchopixel=strlen($o[$l]->zona)*10;?>	
			<span id="etq5"style="width:<?php echo $anchopixel;?>px;"><?php echo $o[$l]->zona;?> =</span>
			<?php echo " S/. ",$o[$l]->monto," (",$o[$l]->cuenta,")";
		}
	}
	public function mostrar_lista_cantidades($o,$lista)
	{
		for ($l=0; $l<count($lista); $l++)
		{
			$anchopixel=strlen($o[$l]->zona)*10;?>	
			<span id="etq5"style="width:<?php echo $anchopixel;?>px;"><?php echo $o[$l]->zona;?> =</span>
			<?php echo $o[$l]->cuenta;?><br><?php
		}
	}
}
?>