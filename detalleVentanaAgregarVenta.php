<?php
@session_start();
header('Content-Type: text/html; charset=UTF-8');
include("../../config/conexion.php");
/**SEDE */    
$sqlsede="select idSede,descripcion from sede"; 
$querysede=mysql_query($sqlsede);
mysql_query('SET CHARACTER SET utf8'); 
while($rowsede=mysql_fetch_array($querysede)){ $datasede[]=$rowsede;}

/**Comprobante */    
$sqlcomprobante="select idComprobante,Descripcion from tipo_comprobante Where idComprobante < 3"; 
$querycomprobante=mysql_query($sqlcomprobante);
mysql_query('SET CHARACTER SET utf8'); 
while($rowcomprobante=mysql_fetch_array($querycomprobante)){ $datacomprobante[]=$rowcomprobante;}


?>
<style>
  .modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

/* Estilo para el botón de cerrar */
.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
#search-form {
            margin-bottom: 20px;
        }

        input[type="text"] {
            padding: 8px;
        }

        input[type="submit"] {
            padding: 8px 16px;
            background-color: #4caf50;
            color: white;
            cursor: pointer;
        }
.resultados
{
  letter-spacing: -.015em;
font-weight: 500;
font-size: 22 px;
}
.bg-success{
    background-size: 500%;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    outline: none;
    -webkit-tap-highlight-color: transparent;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}
.bg-success {    
    border-color: #4caf50;
    background-size: 500%;
}
/** FIN MODAL MANUAL */
body {
    text-transform: uppercase;
  }
  .span_fecha {
      right: 2%;
      position: absolute;
      top: 0;
    }

    table {
      width: 100%;
    }

    td {
      padding: 10px;
    }

    label {
      font-weight: bold;
      margin-right: 10px;
    }

    input,
    select {
      width: 100%;
    }
    
#documento-list {
    float: left;
    list-style: none;
    margin-top: -3px;
    padding: 0;
    width: 35%;
    position: absolute;
    z-index: 999999;
}

#documento-list li {
    padding: 10px;
    background: #f0f0f0;
    border-bottom: #bbb9b9 1px solid;
}

#documento-list li:hover {
    background: #ece3d2;
    cursor: pointer;
}

#producto-list {
    float: left;
    list-style: none;
    margin-top: -3px;
    padding: 0;
    width: 58%;
    position: absolute;
    z-index: 999999;
}

#producto-list li {
    padding: 10px;
    background: #5aa6cf;
    border-bottom: #bbb9b9 1px solid;
}

#producto-list li:hover {
    background: #ece3d2;
    cursor: pointer;
}

#search-box {
    padding: 10px;
    border: #a8d4b1 1px solid;
    border-radius: 4px;
}
.datos-cliente {
      background-color: #f2f2f2;
      font-weight: bold;
    }
.leyenda {
      font-weight: bold;
      border-bottom: 2px solid #000;
    }
/* Estilos para resaltar la columna clicada */
#data-table th.sorted-asc {
    background-color: #f2f2f2;
}

#data-table th.sorted-desc {
    background-color: #f2f2f2;
}

/* Estilos para los iconos de ordenación */
#data-table th i {
    margin-left: 5px;
    font-size: 10px;
    opacity: 0.5;
}

#data-table th.sorted-asc i.fa-arrow-up,
#data-table th.sorted-desc i.fa-arrow-down {
    opacity: 1;
}
</style>
<div class="page-content">
				<div id="home"><div id="resultado_citas" class="buscador oculto">


</div>
<div style="left: 2%; width: 94%;  padding-left: 2%;  padding-top: 2%;">

<form id="form" class="form-horizontal">


<input type="hidden" id="id_paciente">


<input value="" type="hidden" id="id_usuario">


<input type="hidden" name="id_cita_med" id="id_cita_med">


<div id="datos_cliente">
<div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">DATOS CLIENTE</h3>
      </div>

	


<div class="form-group">


<label for="nombre" class="control-label col-xs-1">NOMBRE</label>


		<div class="col-xs-9">					


			<div class="input-group">


			  <input type="text" tabindex="1" id="c_nombre" onkeyup="bus_cli_farm_c();" onblur="if (this.value == '') {this.value = 'Buscar Clientes Por Nombre...';}" onfocus="if (this.value == 'Buscar Clientes Por Nombre...') {this.value = '';}" class="form-control" style="height:30px;" placeholder="  Buscar Clientes Por Nombre...">


				<span class="input-group-addon" onclick="mostrar_ocultar(datos_paciente);ocultar(datos_cliente)"><a>+</a></span>


			</div>


			<div class="caja_lista_f" id="info_cliente" style="display:none;"></div>


		</div>


</div>


<div class="form-group">


<label for="DNI" class="control-label col-xs-1">DNI</label>


		<div class="col-xs-1">			


			  <input type="text" style="height:17px;" class="form-control input-sm" tabindex="2" maxlength="8" onkeypress="return  soloNumeros(event);" id="dni_ruc" onblur="validar_cliente();" placeholder="DNI Paciente">


		</div>





<label for="DIRECCION" class="control-label col-xs-1">DIRECCION</label>


		<div class="col-xs-6" style="width: 52%;">


			  <input type="text" style="height:17px;" class="form-control input-sm" tabindex="3" id="c_dir" maxlength="60" value="" readonly="readonly" placeholder="DIRECCION">





		</div>


</div>


<div class="form-group">





<label for="medicotra" class="control-label col-xs-1">MEDICO TRAT.</label>


		<div class="col-xs-9">					


		<input type="text" style="height:17px;" class="form-control input-sm" readonly="readonly" tabindex="4" id="med_tratante" placeholder="">


		</div>


</div>





</div>


</div>


<div id="datos_paciente" class="oculto">


<div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">DATOS PACIENTE NUEVO</h3>
      </div>






<img src="../../images/bmin.png" alt="" border="0" title="Nuevo paciente" onclick="mostrar_ocultar(datos_paciente);mostrar_ocultar(datos_cliente)">


<div class="form-group">


	<label for="dninue" class="control-label col-xs-1">DNI</label>


	<div class="col-xs-3">		


	<input type="text" style="height:17px;" class="form-control input-sm" id="pac_telefono_2" name="pac_telefono_2">


	</div>


	<label for="nombnue" class="control-label col-xs-1">Nombres</label>


	<div class="col-xs-4">	


	<input type="text" style="height:17px;" class="form-control input-sm" id="pac_nombres_2" name="pac_nombres_2">


	</div>


</div>


<div class="form-group">


	<label for="apepatnue" class="control-label col-xs-1">Apellido Pat.</label>


	<div class="col-xs-3">		


	<input type="text" style="height:17px;" class="form-control input-sm" id="pac_ape_pat_2" name="pac_ape_pat_2">


	</div>


<label for="apematnue" class="control-label col-xs-1">Apellido Mat.</label>


<div class="col-xs-4">		


	<input type="text" style="height:17px;" class="form-control input-sm" id="pac_ape_mat_2" name="pac_ape_mat_2">


</div>


</div>


<div class="form-group">


	<label for="medexter" class="control-label col-xs-1">Medico Externo</label>


	<div class="col-xs-9">		


	<input type="text" style="height:17px;" class="form-control input-sm" id="med_ext" name="med_ext">


	</div>


</div>


<div class="oculto"><input type="button" value="Registrar" id="registra_pac" onclick="registra_pac_head_2()"></div>


</div>


</div>


<div id="div_producto"> 
<div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">DATOS PRODUCTO</h3>
      </div>


<input type="hidden" id="num_campos" name="num_campos" value="0">


<input type="hidden" id="cant_campos" name="cant_campos" value="0">


<input name="id_art" readonly="readonly" type="hidden" id="id_art" size="25" maxlength="15">


<div class="form-group">


	<label for="descrprod" class="control-label col-xs-1">DESCRIPCION</label>


    <div class="col-xs-9">	


	<input type="text" style="height:17px;" name="des" id="des" onkeyup="bus_prod_farm_c();" class="form-control input-sm" value="Buscar Productos Por Descripcion..." onblur="if (this.value === '') {this.value = 'Buscar Productos Por Descripcion...';}" onfocus="if (this.value === 'Buscar Productos Por Descripcion...') {this.value = '';}">
<div class="caja_lista_f" id="info_producto" style="display:none;">

	</div>


	


</div>



</div>


<div class="oculto">


                    <label>IGV <b style="color:#F00;">%</b></label>


				    <div class="input-container"><input name="iva" type="text" id="iva" size="8" onfocus="comprobar_estado_igv()" maxlength="5" value="18" onchange="cambio_iva()"></div>


                   <label>PRECIO POR MAYOR <b style="color:#F00;">S/</b></label>


					<div class="input-container"><input name="p_base" readonly="readonly" type="text" id="p_base" size="8" maxlength="10" onchange="actualizar_importe()"></div><br>


</div>





<div class="form-group">


	<label for="precio" style="text-align: left;" class="control-label col-xs-1 text-right">PRECIO <b style="color:#F00;">S/</b></label>


	<div class="col-xs-1"><input name="p_publico" style="height:17px;" class="form-control input-sm" readonly="readonly" type="text" id="p_publico" maxlength="10" onchange="actualizar_importe()"></div>


	<label for="precio" style="text-align: right;" class="control-label col-xs-1 text-right">STOCK</label>


	<div class="col-xs-1"><input name="stock" style="height:17px;" class="form-control input-sm" type="text" id="stock" readonly="readonly" maxlength="3"></div>


    <label for="precio" style="text-align: right;" class="control-label col-xs-1 text-right">CANTIDAD</label>


	<div class="col-xs-1"><input name="cantidad" style="height:17px;" class="form-control input-sm" onkeypress="return  soloNumeros(event)" type="text" id="cantidad" maxlength="3" value="0" onchange="actualizar_importe_v();"></div>


	<div class="oculto"><label>DCTO. <b style="color:#F00;">%</b></label>


	<div class="input-container"><input name="descuento" type="text" value="0" id="descuento" size="8" maxlength="2" onchange="actualizar_importe_v()"></div></div>


	<label for="precio" style="text-align: right;" class="control-label col-xs-1 text-right">SUB-TOTAL <b style="color:#F00;">S/</b></label>


	<div class="col-xs-1"><input name="valor_venta" style="height:17px;" class="form-control input-sm" type="text" id="valor_venta" maxlength="10" value="0" readonly=""></div>


	<button class="btn btn-primary" onclick="inser_temp();agregarFilav(document.getElementById('cant_campos'));"><i class="fa fa-arrow-circle-right "></i></button>





</div>


	


</div>





    <div class="clear"></div>
<div class="oculto">

    <div id="form3" class="form-horiz"><div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">DETALLE DE VENTA</h3>
      </div>


    

   <table width="100%" id="tblDetalle" class="listado">


		<thead>


        	<tr>


                <th>ITEM</th>


				<th>DESCRIPCION</th>


				<th>PRECIO</th>


				<th>CANTIDAD</th>


				<th>DSCTO %</th>


				<th>VALOR VENTA</th>


                <th>ACCION</th>


               </tr>


		</thead>


        <tbody id="tbDetalle" align="center">


      	</tbody>


	</table>





    <table width="30%" align="right">


			  <tbody><tr>


			    <td colspan="2"><label>SUB-TOTAL</label><div class="input-container">


			      <input name="baseimponible" type="text" id="baseimponible" size="12" value="0" align="right" readonly="">


		       </div></td>


			  </tr>


			  <tr>


				<td colspan="2"><label>IGV</label><div class="input-container">


			      <input name="baseimpuestos" type="text" id="baseimpuestos" size="12" align="right" value="0" readonly="">


		        </div></td>


			  </tr>


			  <tr>


				<td colspan="2"><label>TOTAL</label><div class="input-container">


			      <input name="preciototal" type="text" id="preciototal" size="12" align="right" value="0" readonly="">


		        </div></td>


			  </tr>


		</tbody></table>


        <br>


        <table align="center" width="70%">


   <tbody><tr>


   <td colspan="2"><input type="button" onclick="mostrar(div_pago);ocultar(div_producto);" style="text-align:center;" value="Continuar">


   <input type="button" onclick="cancelarFormulario();" style="text-align:center;" value="Cancelar"></td>


   </tr>


</tbody></table>


<iframe id="frame_clientes" name="frame_clientes" width="0" height="0" frameborder="0">


					<ilayer width="0" height="0" id="frame_clientes" name="frame_clientes"></ilayer>


					</iframe>








</div>


    </div>


         <iframe id="frame_clientes_ruc" name="frame_clientes_ruc" width="0" height="0" frameborder="0">


					<ilayer width="0" height="0" id="frame_clientes_ruc" name="frame_clientes_ruc"></ilayer>


					</iframe>


</div>


<div id="div_pago" class="oculto">


<br>




<label>Total</label><input type="hidden" id="v_cita" name="v_cita" value="">


<input type="text" id="valor_cita" name="valor_cita" value="">


<input type="hidden" readonly="yes" id="mon_des" name="mon_des">


<br>


<div id="cmoneda" style="display:none;">




</div>


<label>Aplicar Descuento</label><select name="a_descuento" id="a_descuento" onchange="muestra_descuento()"><option value="1">Si</option><option value="0" selected="selected">No</option></select><br>


<div id="f_descuentos" class="oculto">


<label>Tipo Descuento</label><select id="t_descuento" name="t_descuento"><option value="1">Cantidad</option><option value="2">Porcentaje</option></select><br>


<label>Cantidad</label><input type="text" onblur="calcula_descuento()" id="d_cantidad" name="d_cantidad"><br>


<label>Costo_real</label><input type="text" id="d_real" name="d_real" readonly=""><div id="res_autorizacion"><label id="autorizado" onclick="mostrar_ocultar(autorizacion)">No Autorizado</label><input type="hidden" name="e_autorizacion" id="e_autorizacion" value="0"></div><br>


<div id="autorizacion" class="oculto">


<label>Usuario</label><input type="text" name="a_usuario" id="a_usuario"><br>


<label>Contrase�a</label><input type="password" onblur="consulta_autorizacion()" name="a_password" id="a_password"><br>


</div>


</div>


<div id="nuevo_paciente" class="oculto">





<h2>complete los datos del paciente</h2>





<label>tipo documento identidad</label><select name="id_tipo_documento_identidad" id="id_tipo_documento_identidad" class="combo_grande" onblur="verificar_dni()" onchange="verificar_dni()">





			<option value="">seleccione</option>





			




			</select><br>





<label>dni</label>





<input type="text" onblur="verificar_dni()" id="pac_dni" name="pac_dni" class="caja_grande"><br>





<label>apellidos</label>





<input type="text" id="pac_ape_pat" name="pac_ape_pat" class="caja_grande"><br>





<label>nombres</label><input type="text" id="pac_nombres" name="pac_nombres" class="caja_grande"><br>





<label>correo electrónico</label><input type="text" id="pac_email" name="pac_email" class="caja_grande"><br>





<label>teléfono</label><input type="text" id="pac_telefono_casa" name="pac_telefono_casa" class="caja_grande"><br>





</div>





<label>comprobante</label><select name="id_comprobante" id="id_comprobante" tabindex="1" onchange="cambiar_comprobante_f()">


                <option value="0">seleccione</option>


			

</select><br>


        





<div id="resultado_comprobante">










</div>		





<label>tipo pago</label><select name="id_tipo_pago" id="id_tipo_pago" onchange="cambiar_tipo_pago()">





			<option value="">seleccione</option>





			




			</select><br>





            


<input type="hidden" id="tipo_moneda" name="tipo_moneda" value="1">


			<iframe id="frame_datos" name="frame_datos" width="0" height="0" frameborder="0">











<ilayer width="0" height="0" id="frame_datos" name="frame_datos"></ilayer>











	  </iframe>





<div id="resultado_tipo_pago">







<br>


</div>





<input type="hidden" id="n" name="n" value="2024-02-14">





<input type="button" onclick="enviarFormulariov();" style="text-align:center;" name="acc" value="Registrar">


<input type="button" onclick="ocultar(div_pago);mostrar(div_producto);" style="text-align:center;" value="Regresar">


</div>


  
  </div></form></div></div>
				<div id="divBloqueador" class="oculto"></div>
<div id="divGestion" class="oculto"></div>
<div id="divIngreso" class="oculto"></div>
<div id="divalert" class="oculto"></div>
<div id="divMantenimiento" class="oculto"></div>
			</div>
<fieldset style="margin: 0; width: 100%;">    
    <!-- Agrega más filas según sea necesario -->

    </table>
	<h4 class="center" style="left:4%">VENTAS FARMACIA</h4>
    
    <span style="right:2% ; position: absolute;top:0px">Fecha: <?php echo date('d-m-Y'); ?> <input type="hidden" id="txtFechaCreacion" value="<?php echo date('Y-m-d'); ?>" /> </span>
	<div id="capaFormulario">   
  
		<form class="form-horizontal" id="form_comprobantes">

        <table style="width: 100%; border-collapse: collapse;" class='table table-bordered table-striped table'>
        <tr>
            <th rowspan="3" style="width: 60%;padding-left:0;">
            <a class='btn btn-success btn-xs pull-right' style='margin-top: 15px;color:#ffffff;' onclick='abrirModal();'> <i class='fa fa-plus'></i>Agregar(F2)</a>
            <div style="height: 250px; min-height: 0px;border-top: 1px solid #E1E1E1;">                
                <table id="venta-table" class="table table-bordered">
                  <thead>
                      <tr>
                          <th>Descripción</th>
                          <th>Cantidad</th>
                          <th>Precio Venta</th>
                          <th>Total</th>
                          <th>Accion</th>
                      </tr>
                  </thead>
                  <tbody id="venta-table-body">
                      <!-- Aquí se llenarán los productos seleccionados -->
                  </tbody>
              </table>


            </div>
            </th>
            <td style="width: 40%;padding-left:0;">
            <div class="col-xs-10">                
            <label for="inputComprobante"><i class="fa fa-credit-card"></i> Documento:</label>
            <select id="cbComprobante" class="form-control" name="cbComprobante" style="font-size:11px; ">
                                <?php foreach($datacomprobante as $datcomprobante)
                                { echo '<option value="'.$datcomprobante['idComprobante'].'" '.$selected.'>'.$datcomprobante['Descripcion'].'</option>';}
                                ?>
            </select>
            </div>
            <div class="col-xs-5">
            <label for="numeroDocumentoLabel"><i class="fa fa-credit-card"></i> Serie:</label>
            <input type="text" id="numeroDocumento" name="numeroDocumento" class="form-control" disabled>
            </div>
            <div class="col-xs-5">                           
            <label for="inputcorrelativoLabel"><i class="fa fa-user"></i> Numero:</label>
            <input type="text" id="txtnombrecorrelativo" name="txtnombrecorrelativo" class="form-control" disabled>
            <select style="display:none;" id="txtsede" class="form-control" name="txtsede" style="font-size:11px; ">
                                <?php foreach($datasede as $datsede)
                                { echo '<option value="'.$datsede['idSede'].'">'.$datsede['descripcion'].'</option>';}
                                ?>
                                </select>
            </div>             
            
            
          </td>
        </tr>
        <tr>            
            <td style="width: 40%;padding-left:0;">
            <div class="col-xs-5">
            <label for="tipoDocumentoLabel"><i class="fa fa-credit-card"></i> Tipo de Documento:</label>
            <select id="tipoDocumento" name="tipoDocumento" class="form-control">
              <option value="DNI">DNI</option>
              <option value="CE">C.E.</option>
              <!-- Puedes agregar más opciones aquí si es necesario -->
            </select>
            </div>
            <div class="col-xs-5">                           
            <label for="numeroDocumentoLabel" id="numeroDocumentoLabel"><i class="fa fa-credit-card"></i> N° de Doc. :</label>
            <input type="text" id="txtndocumento" name="txtndocumento" class="form-control" placeholder='Ingresar Texto' aria-label='Ingresar Texto' autocomplete="off" required>
            </div>       
          </td>
        </tr>
        <tr>
            <td style="width:40%;padding-left:0;">
            <div class="col-xs-10">
                
            <label for="nombreClienteLabel" id="nombreClienteLabel"><i class="fa fa-user"></i> Nombre del Cliente:</label>            
            <input type="text" id="nombreCliente" name="nombreCliente" class="form-control">
            <label for="direccionLabel" id="direccionLabel"><i class="fa fa-map-marker"></i> Dirección:</label>
            <input type="text" id="direccion" name="direccion" class="form-control"> 

            </div>
            </td>
        </tr>
        </table>
	    </form>

        <table style="width: 100%;border: 1px solid #ddd;">
        <tr>
            <th style="width: 60%;border-right: 1px solid #ddd;">
                <div class="col-xs-11 center">
                <h4>DETALLE DOCUMENTO</h4>                
                </div>
            </th>
            <td style="width: 40%;font-weight:bold;border-top: none;">
                <div class="col-xs-11 center">
                <h4>RESUMEN</h4>                
                </div>
            </td>
        </tr>
        <tr>
            <td style="width: 60%;padding-left:0;border-right: 1px solid #ddd;">
            <div class="col-xs-5">
                <label for="recibidoLabel" id="recibidoLabel"><i class="fa fa-money"></i> Tipo de Pago: </label>                
            </div>
            <div class="col-xs-5">                           
                <select id="tipoPago" name="tipoPago" class="form-control">
                <option value="Efectivo">Efectivo</option>
                <option value="Yape">Yape</option>
                <option value="Plin">Plin</option>
                <option value="Tarjeta">Tarjeta</option>
                </select> 
            </div> 
            </td>
            <td style="width: 40%;font-weight:bold;border-top: none;">
                <div class="col-xs-5">
                    <h3 for="recibidoLabel" id="recibidoLabel">SUB TOTAL </h3>                
                </div>
                <div class="col-xs-5 pull-right" style="width:10%;">                           
                <h3 class="resultados" id="suma_subtotal">S/ 0.00</h3>
                </div> 
            </td>
        </tr>
        <tr>
            <td style="width: 60%; padding-left:0;border-right: 1px solid #ddd;">
                <div class="col-xs-5">
                <label for="recibidoLabel" id="recibidoLabel">¿Es Copago?:</label>
                <select id="selectCopago" name="selectCopago" class="form-control">
                <option value="No">No</option>
                <option value="Si">Si</option>
                </select> 
                </div>
                <div class="col-xs-5">                
                <label for="porcentajecopagoLabel" id="porcentajecopagoLabel">COPAGO en %</label>
                <input type="number" id="txtcopagoporcentaje" name="txtcopagoporcentaje" class="form-control" min='1' max='100'>  
                </div>  
               
            </td>
            <td style="width: 40%;font-weight:bold;border-top: none;">
                <div class="col-xs-5">
                    <h3 for="recibidoLabel" id="recibidoLabel">IGV (18%)</h3>                
                </div>
                <div class="col-xs-5 pull-right" style="width:10%;">                           
                <h3 class="resultados" id="suma_igv">S/ 0.00</h3>
                </div> 
            </td>            
        </tr>
        <tr>
            <td style="width: 60%; padding-left:0;border-right: 1px solid #ddd;">
                <div class="col-xs-5">
                <label for="empresaLabel" id="empresaLabel">EMPRESA:</label>
                <select id="selectEmpresa" name="selectEmpresa" class="form-control">                
                <option value="MAPFRE">MAPFRE</option>
                <option value="POSITIVA">LA POSITIVA</option>
                <option value="RIMAC">RIMAC</option>
                <option value="SANITAS">SANITAS</option>
                <option value="REDSALUD">REDSALUD</option>
                <option value="CHUBB">CHUBB</option>
                <option value="PACIFICO">PACIFICO</option>
                </select> 
                </div>
                <div class="col-xs-5">       
                <label for="titularLabel" id="titularLabel">Numero Doc. Titular (ENTER BUSCAR):</label>         
                <input type="text" id="txtdoctitular" name="txtdoctitular" class="form-control" placeholder='Ingresar N° Documento' aria-label='Ingresar N° Documento' autocomplete="off" required>                
                </div>               
            </td>   
            <td style="width: 40%;font-weight:bold;border-top: none;">
                <div class="col-xs-5">
                    <h3 for="recibidoLabel" id="recibidoLabel">IMPORTE TOTAL </h3>                
                </div>
                <div class="col-xs-5 pull-right" style="width:10%;">                           
                <h3 class="resultados" style="color:#2196f3;" id="suma_total">S/ 0.00</h3>
                </div> 
            </td>          
        </tr>
        <tr>
            <td style="width: 60%; padding-left:0;border-right: 1px solid #ddd;">
                <div class="col-xs-11">
                <label for="nombreTitularLabel" id="nombreTitularLabel"><i class="fa fa-user"></i> Nombre del Titular:</label>            
                <input type="text" id="nombreTitular" name="nombreTitular" class="form-control">
                </div>              
            </td>
            <td style="width: 40%;font-weight:bold;border-top: none;">
                <div class="col-xs-5 pull-right">
                <label for="recibidoLabel" id="recibidoLabel">Total Recibido S/</label>
                <input type="text" id="txtrecibido" name="txtrecibido" class="form-control" autocomplete="off">  
                </div>
            </td>         
        </tr>
        <tr>
            <td style="width: 60%;padding-left:0;border-right: 1px solid #ddd;">       
            <div class="col-xs-11">
                <label for="observacionLabel" id="observacionLabel">Observacion</label>
                <textarea rows="3" cols="2" id="observacion_documento" name="observacion_documento" class="form-control" placeholder="Escribe aquí una observación"></textarea>
            </div>
            </td>
            <td style="width: 40%;font-weight:bold;border-top: none;">
                <div class="col-xs-5 pull-right">
                <label for="vueltoLabel" id="vueltoLabel">Vuelto S/</label>
                <input type="text" id="txtvuelto" name="txtvuelto" class="form-control" disabled>   
                </div>
            </td>             
        </tr>

        </table>
    </div>

    <form>
        <div class="center">
        <input id="totalVendido" type="hidden" value='.$granTotal.'>
        <br>
        <br>
        <br>
		<a onclick="completarVenta()" class="btn btn-success">VENDER PRODUCTOS (F4)</a>
		<!--<a onclick="cancelarVenta()" class="btn btn-danger">Cancelar venta</a>-->
        </div>
		
		
	</form>
<br />
</fieldset>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
        <!-- Formulario de búsqueda -->
                <table class="table table-bordered table-striped table">
                    <tbody>
                        <tr>
                            <td colspan="7"> <b>Filtrar por:</b></td>
                        </tr>
                        <tr>
                            <td class="text-primary col-md-1">
                                <select id="search-criteria" class="form-control">
                                    <option value="descripcion">Descripción</option>
                                    <option value="laboratorio">Laboratorio</option>
                                </select>
                            </td>
                            <td colspan="5" class="col-md-8">
                                <input type="text" class="form-control" id="search-input" autocomplete="off" name="search-input" placeholder="Buscar Producto...">
                            </td>
                            <td class="text-primary col-md-1">
                                <a href="#" class="btn btn-success" id="btnBuscar">Buscar</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div id="table-container" style="max-height: 300px; overflow-y: auto;">
                <!-- Tabla -->                
                <table id="data-table" class="table">
                <thead>
                    <tr>
                        <th data-column="descripcion">Descripción<div class="icon-container"><i class="fa"></i></div></th>
                        <th data-column="laboratorio">Laboratorio<div class="icon-container"><i class="fa"></i></div></th>
                        <th data-column="stock">Stock<div class="icon-container"><i class="fa"></i></div></th>
                        <th data-column="precioVenta">Precio Venta<div class="icon-container"><i class="fa"></i></div></th>
                        <th data-column="lote"><div class="icon-container"><i class="fa"></i></div>Lote</th>
                        <th data-column="fechaVencimiento"><div class="icon-container"><i class="fa"></i></div>Fecha Vencimiento</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                    <tbody>
                        <!-- Los datos se cargarán aquí dinámicamente -->
                    </tbody>
                </table>
                <!--Fin Tabla -->
                </div>
        </div>

        
            


    </div>


<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>    
    var productosVenta = [];
var data = [];
var filteredData = []; // Datos filtrados
var sortOrder = 'asc'; // Estado de ordenación global
var sortedColumn; // Columna actualmente ordenada


    // Función para manejar la búsqueda y ordenación al hacer clic en el enlace
$('#btnBuscar').on('click', function(e) {
    e.preventDefault();

    var searchTerm = $('#search-input').val().toLowerCase();
    var searchCriteria = $('#search-criteria').val();

    // Filtrar los datos
    var filteredData = $.grep(data, function(item) {
        return item[searchCriteria].toLowerCase().indexOf(searchTerm) !== -1;
    });

    // Actualizar la tabla con los datos filtrados
    loadTable(filteredData);
});
loadTable(data);
function loadTable(dataToLoad) {
    var tbody = $('#data-table tbody');
    tbody.empty();

    if (!dataToLoad) {
        console.error('Data to load is undefined or null');
        return;
    }

    $.each(dataToLoad, function(index, item) {
        var fechaVencimientoFormateada = moment(item.fechaVencimiento).format('DD/MM/YYYY');
        var stock = parseFloat(item.stock);
        var precioVenta = parseFloat(item.precioVenta);

        var row = '<tr>' +
            '<td>' + item.descripcion + '</td>' +
            '<td>' + item.laboratorio + '</td>' +
            '<td data-column="stock"><strong>' + stock + '</strong></td>' +
            '<td data-column="precioVenta">' + precioVenta.toFixed(2) + '</td>' +
            '<td>' + item.lote + '</td>' +
            '<td>' + fechaVencimientoFormateada + '</td>' +
            '<td><button class="btn btn-success agregar-venta" data-index="' + index + '"><i class="fa fa-shopping-cart"></i></button></td>' +
            '</tr>';

        tbody.append(row);
    });

    // Asignar el manejador de clic para los botones "AGREGAR A VENTA"
    $('.agregar-venta').click(function() {
        var index = $(this).data('index');
        agregarAVenta(dataToLoad[index]);
    });
}

function sortTable(column) {
    // Cambiar el orden
    sortOrder = sortOrder === 'asc' ? 'desc' : 'asc';

    // Determinar qué conjunto de datos ordenar
    var dataToSort = filteredData.length > 0 ? filteredData : data;

    // Ordenar el array de datos
    dataToSort.sort(function(a, b) {
        var aValue = column === 'stock' ? parseFloat(a.stock) : column === 'precioVenta' ? parseFloat(a.precioVenta) : a[column];
        var bValue = column === 'stock' ? parseFloat(b.stock) : column === 'precioVenta' ? parseFloat(b.precioVenta) : b[column];

        if (sortOrder === 'asc') {
            return aValue > bValue ? 1 : -1;
        } else {
            return aValue < bValue ? 1 : -1;
        }
    });

    // Recargar la tabla con los datos ordenados
    loadTable(dataToSort);
}






    // Inicializar la tabla con los datos iniciales
    $(document).ready(function() {        
        $.ajax({
            url:'../controller/co_inventario.php',
            data:{cargarProductosVender:1},
            type: 'GET',
            dataType: 'json',
            success: function (datosObtenidos) {
                // Verifica si se obtuvieron datos correctamente
                if (datosObtenidos && datosObtenidos.length > 0) {
                // Actualiza el array data con los nuevos resultados
                Array.prototype.push.apply(data, datosObtenidos);
                
                // Llama a loadTable después de que se hayan actualizado los datos
                loadTable(data);
                $('#data-table th').click(function() {
                    var column = $(this).data('column') || $(this).index(); // Obtener el nombre o índice de la columna
                    sortTable(column);
                    // Eliminar las clases de resaltado y reiniciar iconos en todas las columnas
                    $('#data-table th').removeClass('sorted-asc sorted-desc');
                    $('#data-table th i').removeClass('fa-sort-up fa-sort-down');

                    // Aplicar el resaltado y el icono a la columna clicada
                    $(this).addClass(sortOrder === 'asc' ? 'sorted-asc' : 'sorted-desc');
                    $(this).find('i').addClass(sortOrder === 'asc' ? 'fa-sort-up' : 'fa-sort-down');
                });

                // Aquí puedes realizar cualquier otra acción con los datos obtenidos
                } else {
                    console.error('Error al obtener productos');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error en la solicitud AJAX:', error);
            }
        });        
        
    });
    $('#search-input').on('input', function() {    
    if (event.which === 13) {
        event.preventDefault(); // Evitar la acción predeterminada
        return;
    }
    var searchTerm = $(this).val().toLowerCase();

    // Filtrar los datos en base al término de búsqueda
    filteredData = data.filter(function(item) {
        return Object.values(item).some(function(value) {
            return value.toString().toLowerCase().includes(searchTerm);
        });
    });

    // Ordenar y cargar la tabla con los datos filtrados
    sortTable(filteredData);
});

    function agregarAVenta(producto) {
    // Verificar si la descripción ya existe en el array
    var existe = productosVenta.some(function(item) {
        return item.id_detalle === producto.id_detalle;
    });

    if (existe) {
        // Si la descripción ya existe, mostrar un mensaje y no agregar el producto
        Swal.fire(
            'Producto Existente',
            'Este producto ya fue agregado a la venta.',
            'warning'
        );
    } else {
    // Si la descripción no existe, solicitar la cantidad a insertar
    Swal.fire({
        title: 'Ingrese la cantidad',
        input: 'number',
        inputAttributes: {
            autocapitalize: 'off',
            max: producto.stock  // Establecer el valor máximo del campo de entrada como el stock disponible
        },
        showCancelButton: true,
        confirmButtonText: 'Agregar a Venta',
        showLoaderOnConfirm: true,
        preConfirm: (cantidad) => {
            // Verificar si se ingresó una cantidad válida
            cantidad = parseFloat(cantidad); // Convertir a número

            if (isNaN(cantidad) || cantidad <= 0 || cantidad > producto.stock) {
                Swal.showValidationMessage(`Por favor, ingrese una cantidad válida menor o igual a ${producto.stock}.`);
            }
            return cantidad;
        },
        allowOutsideClick: () => !Swal.isLoading()
      }).then((result) => {
          if (result.isConfirmed) {
              // Obtener la cantidad ingresada
              var cantidad = result.value;
              
              // Actualizar la cantidad en el objeto del producto

              producto.cantidad = cantidad;
              producto.total = (producto.cantidad*producto.precioVenta).toFixed(2);

              // Agregar el producto al array global
              productosVenta.push(producto);

              // Actualizar la tabla de venta
              actualizarTablaVenta();
          }
      });
    }

}
function calcularSumaTotal() {    

    var sumaTotal = 0;
    // Iterar sobre el array productosVenta y sumar las cantidades
    $.each(productosVenta, function(index, producto) {
        sumaTotal += parseFloat(producto.total) || 0; // Asegurarse de que el valor sea numérico
    });
    
    $('#suma_subtotal').text('S/' +(sumaTotal*0.82).toFixed(2));
    $('#suma_igv').text('S/' +(sumaTotal-(sumaTotal/1.18)).toFixed(2));
    $('#suma_total').text('S/' +sumaTotal.toFixed(2));

    return sumaTotal.toFixed(2);
    
}

$('#txtrecibido').on('change', function() {
    var sumaTotal =  calcularSumaTotal();
    var txtRecibido = parseFloat($('#txtrecibido').val()) || 0;
    // Verificar si hay que calcular el vuelto
    if (sumaTotal > 0 && txtRecibido >= sumaTotal) {
        var vuelto = txtRecibido - sumaTotal;
        $('#txtvuelto').val(vuelto.toFixed(2));
    } else {
        // Si no hay vuelto, puedes limpiar el campo txtvuelto
        $('#txtvuelto').val('');
    }    
});

// Función para actualizar la tabla de venta
function actualizarTablaVenta() {
    var tbodyVenta = $('#venta-table-body');
    tbodyVenta.empty();

    $.each(productosVenta, function(index, producto) {
        var row = '<tr>' +
            '<td>' + producto.descripcion + '</td>' +                     
            '<td>' + producto.cantidad + '</td>' +
            '<td>' + producto.precioVenta + '</td>' +
            '<td>' + producto.total + '</td>' +
            '<td><button onclick="eliminarProductoVenta(' + index + ')">Eliminar</button></td>' +            
            '</tr>';

        tbodyVenta.append(row);
    });

    // Actualizar el elemento HTML con la suma total
    calcularSumaTotal();
}
function eliminarProductoVenta(index) {
    // Eliminar el producto del array productosVenta
    productosVenta.splice(index, 1);
    
    // Actualizar la tabla de venta
    actualizarTablaVenta();
}


</script>



<script type="text/javascript">


$(document).ready(function() {
    // Cerrar el modal al hacer clic en el botón de cerrar
    $(".close").click(function() {
        $("#myModal").hide();
    });

    // Cerrar el modal al hacer clic fuera del contenido del modal
    $(window).click(function(event) {
        if (event.target == $("#myModal")[0]) {
            $("#myModal").hide();
        }
    });


  // Llamada AJAX al cargar la página
  obtenerSiguienteNumero(); // Llamada inicial al cargar la página
  checkCopago();

  // Manejar cambios en el select
  $('#cbComprobante').change(function() {
  obtenerSiguienteNumero(); // Llamada AJAX al cambiar el tipo de documento
  });

  $(document).keydown(function(e) {
        if (e.key === "F2") {
            abrirModal();
        }
    });

    $("#txtproducto").keyup(function() {
        var texto_buscar = $('#txtproducto').val();
        $.ajax({
            type: "POST",
            url: "../controller/co_inventario.php",
            data: {buscarproductoVenta:1,texto_buscar:texto_buscar},
            beforeSend: function() {
                $("#txtproducto").css("background", "#FFF url(LoaderIcon.gif) no-repeat 165px");
            },
            success: function(data) {
                $("#producto-box").show();
                $("#producto-box").html(data);
                $("#txtproducto").css("background", "#FFF");
            }
        });
    });
});

function abrirModal() {
    // Aquí puedes agregar el código necesario para mostrar la ventana modal    
    $("#myModal").show();
}

$('#txtndocumento').on('keydown', function(event) {
    if (event.key === 'Enter') {
        // Ejecutar la función ConsultarDoc cuando se presiona Enter
        ConsultarDoc();
    }
});
$('#txtdoctitular').on('keydown', function(event) {
    if (event.key === 'Enter') {
        // Ejecutar la función ConsultarDoc cuando se presiona Enter
        ConsultarTitular();
    }
});

function ConsultarTitular()
{  
  var nro_documento = $('#txtdoctitular').val();
  var tipoDoc = 1;
  $.ajax({          
          type: 'POST',
          url: "../controller/co_inventario.php",
          data: { ConsultarDoc:1,tipoDoc:tipoDoc, nro_documento:nro_documento},
          dataType: 'json',
          success: function(data) {       
            if (tipoDoc == 1) //DNI
            {              
              $('#nombreTitular').val(data.nombres + ' ' + data.apellidoPaterno + ' ' + data.apellidoMaterno);
            }
            // Caso 2
            else if (tipoDoc == 2) //CE
            {
             alert('En proceso');
            }
            else if (tipoDoc == 3) //RUC
            {
              $('#nombreCliente').val(data.razonSocial);            
              $('#direccion').val(data.direccion);  
            }
          

          },
          error: function(error) {
            console.log('Error en la llamada AJAX:', error);
          }
        });


}
function ConsultarDoc()
{
  var tipoDoc = $('#tipoDocumento').val();
  var nro_documento = $('#txtndocumento').val();
  $.ajax({          
          type: 'POST',
          url: "../controller/co_inventario.php",
          data: { ConsultarDoc:1,tipoDoc: tipoDoc, nro_documento:nro_documento},
          dataType: 'json',
          success: function(data) {       
            if (tipoDoc == 1) //DNI
            {              
              $('#nombreCliente').val(data.nombres + ' ' + data.apellidoPaterno + ' ' + data.apellidoMaterno);
            }
            // Caso 2
            else if (tipoDoc == 2) //CE
            {
             alert('En proceso');
            }
            else if (tipoDoc == 3) //RUC
            {
              $('#nombreCliente').val(data.razonSocial);            
              $('#direccion').val(data.direccion);  
            }
          

          },
          error: function(error) {
            console.log('Error en la llamada AJAX:', error);
          }
        });


}

$('#selectCopago').change(function() {
    checkCopago(); // Llamada AJAX al cambiar el tipo de documento
  });

function checkCopago()
{
    var tipoCopago = $('#selectCopago').val();
    if (tipoCopago == 'Si')
    {
        $('#txtcopagoporcentaje').prop('disabled', false);                
        $('#selectEmpresa').prop('disabled', false);        
        $('#txtdoctitular').prop('disabled', false);        
        $('#nombreTitular').prop('disabled', false);
        
    }
    
    else
    {
        $('#txtcopagoporcentaje').prop('disabled', true);                
        $('#selectEmpresa').prop('disabled', true);        
        $('#txtdoctitular').prop('disabled', true);        
        $('#nombreTitular').prop('disabled', true);
    }
}
function obtenerSiguienteNumero() {
        var tipoDocumento = $('#cbComprobante').val();
        // Llamada AJAX
        $.ajax({          
          type: 'GET',
          url: "../controller/co_inventario.php",
          data: { correlativoDocumento:1,tipoDocumento: tipoDocumento },
          dataType: 'json',
          success: function(data) {
            // Manipula el resultado, por ejemplo, colócalo en algún elemento HTML
            //$('#resultado').html('El siguiente número de ' + tipoDocumento + ' es: ' + data);            
            $('#txtnombrecorrelativo').val(data.ultimoNumero);
            $('#numeroDocumento').val(data.serie);
            // Mostrar u ocultar elementos según el valor de cbComprobante

            // Caso 1
            if (tipoDocumento == 1) {              
              $('#txtndocumento').val('');
              $('#nombreCliente').val('');
              $('#direccion').val('');
              $('#numeroDocumentoLabel').text('Número de Documento (ENTER BUSCAR)');
              $('#nombreClienteLabel').text('Nombre del Cliente:');
              $('#direccionLabel').hide();
              $('#direccion').hide();
              $('#tipoDocumento').empty()
              .append($('<option>', { value: '1', text: 'DNI' }))
              .append($('<option>', { value: '2', text: 'C.E.' }));
            }
            // Caso 2
            else if (tipoDocumento == 2) {
              $('#txtndocumento').val('');
              $('#nombreCliente').val('');
              $('#direccion').val('');
              $('#numeroDocumentoLabel').text('Número RUC:');
              $('#nombreClienteLabel').text('Razón Social:');
              $('#direccionLabel').show();
              $('#direccion').show();
              // Limpiar opciones actuales y agregar nuevas opciones al select tipoDocumento
              $('#tipoDocumento').empty()
              .append($('<option>', { value: '3', text: 'RUC' }));
            }

          },
          error: function(error) {
            console.log('Error en la llamada AJAX:', error);
          }
        });
      }

function btnVentanaVenta(){
    ///

    
    $("#divIngreso").empty();       
    $("#divBloqueador").show();     
    $("#divIngreso").show();
    $("#divIngreso").empty();
    $("#divIngreso").append("<img src='../asset/img/ajax-loader.gif' border='0px' title='Cargando...' alt='Cargando...'><br>Cargando..."); 
	
    var parametros={
        openVentanaConsultarProductoVenta:1,	
        }		            
        $.ajax({
            url:'../controller/co_inventario.php',
            data:parametros,
            dataType:'html',
            type:'POST',
            success: function(datos){                                        
					$("#divIngreso").empty();
                    $("#divIngreso").append(datos);
                    
            },
            error: function(xhr, status, error){
                 var err=("Ocurrio un error:::"+xhr.responseText+error);
                 $("#mensajeError").fadeIn().text(""+err);
            }
        })
    


}
/*
function selectProductoVender(IdDetalle,IdProducto,descripcion,unidad,lote,valor_unitario,id_pivote_precio,tipoProducto) {

    if(tipoProducto=='3'){
        Swal.fire(
                                    'Alerta!',
                                    'Este Producto Requiere Receta',
                                    'warning'
                                    )  
    }

        document.getElementById("txtid_detalle").value = IdDetalle;
        document.getElementById("txtidproducto").value = IdProducto;
        document.getElementById("txtproducto").value = descripcion;        
        document.getElementById("txtunidad").value = unidad;        
        document.getElementById("txtlote").value = lote;        
        document.getElementById("txtprecio_venta").value = valor_unitario;
        document.getElementById("txtpivote_precio").value = id_pivote_precio;
        
        $("#producto-box").hide();
    
}*/
function imprimirVenta(id) {    
    window.open('../controller/co_inventario.php?printPdfComprobante&id_venta='+id,'_blank');    
}
document.addEventListener('keydown', function(event) {
    if (event.key === 'F4') {
        // Lógica que deseas ejecutar al presionar F12
        completarVenta();
    }
});
function completarVenta()
{
    var tipo_comprobante= $('#cbComprobante').val();
    var ndocumento = $('#txtndocumento').val() || '00000000';
    var cliente = $('#nombreCliente').val() || 'Clientes Varios';
    var serie = $('#numeroDocumento').val();
    var numero = $('#txtnombrecorrelativo').val();
    var sede= $('#txtsede').val(); 
    var tipoCopago = $('#selectCopago').val();
    var txtcopagoporcentaje = $('#txtcopagoporcentaje').val();
    var selectEmpresa = $('#selectEmpresa').val();
    var txtdoctitular = $('#txtdoctitular').val();
    var nombreTitular = $('#nombreTitular').val();

    
     // Verificar si hay al menos un producto en la venta
    if (productosVenta.length === 0) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Debes agregar al menos un ítem al documento electrónico...',
            confirmButtonText: 'OK'
        });
        return; // Detener la ejecución si no hay productos
    }

     // Verificar la longitud del número de documento según el tipo de comprobante
    if (tipo_comprobante === '1' && (!ndocumento || ndocumento.length !== 8 || !/^\d+$/.test(ndocumento))) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Para Boletas o C.E. , el número de documento debe tener 8 dígitos numéricos.',
            confirmButtonText: 'OK'
        });
        return; // Detener la ejecución si el número de documento no es válido
    }

    if (tipo_comprobante === '2' && (!ndocumento || ndocumento.length !== 11 || !/^\d+$/.test(ndocumento))) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Para Facturas, el número de documento debe tener 11 dígitos numéricos.',
            confirmButtonText: 'OK'
        });
        return; // Detener la ejecución si el número de documento no es válido
    }

    var sumaTotal = calcularSumaTotal();
     // Verificar si la sumaTotal es mayor a 700
     /*if (sumaTotal > 700) {
        Swal.fire({
            icon: 'error',
            title: 'Error en cliente',
            text: 'Para montos superiores a S/. 700 soles, se debe consignar el nombre y documento electrónico del cliente. ¡Es obligatorio!',
            confirmButtonText: 'OK'
        });
        return; // Detener la ejecución si la sumaTotal es mayor a 700
    }*/

     // Mostrar resumen de ventas en un SweetAlert
     Swal.fire({
        icon: 'warning',
        title: 'Necesitamos tu Confirmación',
        html: '<div style="text-align: center;">' +
            '<div style="font-weight: bold;">Se creará el documento electrónico con los siguientes datos:</div>' +
            '<div class="resultados" style="margin-top: 10px;">Resumen:</div>' +
            '<div class="resultados">SubTotal: '+(sumaTotal/1.18).toFixed(2)+'</div>' +
            '<div class="resultados">IGV: '+(sumaTotal-(sumaTotal/1.18)).toFixed(2)+'</div>' +
            '<div class="resultados" style="color:#2196f3;">Total: '+sumaTotal+'</div>' +
            '<span style="font-size: 18px;color:#4caf50!important">¿Está Usted de Acuerdo?</span>'+
            '</div>',
        confirmButtonText: 'Si, Completar Venta',
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#28a745', // Color verde
        cancelButtonColor: '#dc3545' // Color rojo
    }).then((result) => {
        if (result.isConfirmed) {
          
                          $.ajax({
                                url:'../controller/co_inventario.php',
                                data:{completarVenta:1,tipo_comprobante:tipo_comprobante,ndocumento:ndocumento,cliente:cliente,serie:serie,numero:numero,sede:sede,total_vendido:sumaTotal,productos:productosVenta,tipoCopago:tipoCopago,txtcopagoporcentaje:txtcopagoporcentaje,selectEmpresa:selectEmpresa,txtdoctitular:txtdoctitular,nombreTitular:nombreTitular},
                                dataType:'html',
                                type:'POST',
                                success: function (datos){                                    
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'El Documento se ha Guardado Correctamente!',
                                        html: '<div style="background-color: #e8f5e9; border-color: #4caf50; color: #43a047; padding: 10px; margin-top: 10px;">' +
                                            '<p style="margin: 0;">Se guardó correctamente el documento: B001-7.</p>' +
                                            '<p style="margin: 10px 0;">Gracias por utilizar nuestro servicio. </p>' +
                                            '</div>' +
                                            '<a onclick="imprimirVenta(\'' + datos + '\')" style="margin-top: 10px; display: inline-block;">' +
                                            '<img src="https://sistema.facturamas.pe/facturacion/img/svg/pdf_cpe.svg" style="width: 24px; height: 24px; margin-right: 5px;" alt="PDF">' +
                                            '<span>A4</span>' +
                                            '</a>' +
                                            '<a onclick="imprimirVenta(\'' + datos + '\')" style="margin-top: 10px; display: inline-block; margin-left: 10px;">' +
                                            '<img src="https://sistema.facturamas.pe/facturacion/img/svg/ticket_cpe.svg" style="width: 24px; height: 24px; margin-right: 5px;" alt="Ticket">' +
                                            '<span>Ticket</span>' +
                                            '</a>' +
                                            '<br>' +
                                            '<a href="#" type="button" class="btn bg-success" style="margin-top: 10px;">Lista de Comprobantes</a>',
                                        showCancelButton: false,
                                        confirmButtonColor: '#28a745', // Color verde
                                        confirmButtonText: 'Aceptar',
                                        allowOutsideClick: false, // No permite clic fuera de la ventana
                                        backdrop: 'static' // Evita el cierre haciendo clic fuera de la ventana
                                    });  
                                    
                                },
                                error:function(xhr, status, error){
                                    var err=(xhr.responseText+status+error);
                                    Swal.fire(
                                    'Oooops',
                                    'Ocurrio un error',
                                    'warning'
                                    )
                                    console(err);
                                }                                                            
                            });

        } 
        else 
        {
            // Si el usuario cancela, no hacer nada o realizar alguna acción adicional si es necesario
        }
    });

}
</script>