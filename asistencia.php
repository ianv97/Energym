<?php
	session_start();
	if (!isset($_SESSION["usuario"])) {header("Location: index.php");}
	if ($_SESSION["nacceso"]<3) {header("Location: index.php");}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="css/datatable1.css">
	<link rel="stylesheet" href="css/datatable2.css">
	<link rel="shortcut icon" href="imagen/logo.ico"/>
	<link rel='stylesheet' href="css/estilos.css">
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/datatable3.js"></script>
	<script type="text/javascript" src="js/datatable4.js"></script>
	<script type="text/javascript" src="js/datatable5.js"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/all.js" integrity="sha384-xymdQtn1n3lH2wcu0qhcdaOpQwyoarkgLVxC/wZ5q7h9gHtxICrpcaSUfygqZGOe" crossorigin="anonymous"></script>
	<title>Energym - Asistencia</title>
	<style type="text/css">
	body {position:relative; background-image:url(imagen/fondo-perfil.jpg); z-index: 10000000;}
  	</style>
</head>
<body>

<?php
if (!isset($_SESSION["usuario"])) {require "sidebar.php";
}else{
  switch($_SESSION["nacceso"]) {
    case 0: require "sidebar-usuario.php";break;
    case 1: require "sidebar-profesor.php";break;
    case 2: require "sidebar-secretaria.php";break;
    case 3: require "sidebar-administradora.php";break;
    case 4: require "sidebar-gerente.php";break;
  }
}
?>

<script type="text/javascript">
$(document).ready(function(){ 
   	$('#asistencia-diaxdiab').on('click',function(){
   		if ($('#asistencia-diaxdia').is(":checked")){
      	}else{
      		$('#divdiaxdia').toggle('slow');
      		$('#divtotales').toggle('slow');
   			$('#asistencia-totales').prop('checked',false);
      	};
   });
   $('#asistencia-totalesb').on('click',function(){
   		if ($('#asistencia-totales').is(":checked")){
      	}else{
      		$('#divdiaxdia').toggle('slow');
      		$('#divtotales').toggle('slow');
   			$('#asistencia-diaxdia').prop('checked',false);
      	};
   });
});

$(document).on('submit','#formulario-asistencia', function(event){
	event.preventDefault();
    $.ajax({
      type:"POST",
      data:"accion=4 &" + $(this).serialize(),
      url:"bd.php",
      success:function(r){
        resultado=jQuery.parseJSON(r);
        var tabla="";
        $('#asistencia-tabla').DataTable().clear();
        $('#asistencia-tabla').DataTable().draw();
        for (var i=0; i<resultado.length; i+=1){
        	if (resultado[i]["presente"]==1){
	    		$('#asistencia-tabla').DataTable().row.add( [
				resultado[i]["sucursal"],
	    		resultado[i]["fecha"],
				resultado[i]["apellido"]+", "+resultado[i]["nombre"],
				"<i class=\"fas fa-check\"></i>",
				] ).draw( false );
    		}else{
    			$('#asistencia-tabla').DataTable().row.add( [
	    		resultado[i]["sucursal"],
	    		resultado[i]["fecha"],
				resultado[i]["apellido"]+", "+resultado[i]["nombre"],
				"<i class=\"fas fa-times\"></i>",
				] ).draw( false );
    		};
    		tabla=tabla+resultado[i]["sucursal"]+"*"+resultado[i]["fecha"]+"*"+resultado[i]["apellido"]+", "+resultado[i]["nombre"]+"*"+resultado[i]["presente"]+"!";
    	};
    	$('#asistenciapdf-finicio').val(document.getElementById("asistencia-finicio").value);
    	$('#asistenciapdf-ffin').val(document.getElementById("asistencia-ffin").value);
    	$('#asistenciapdf-tabla').val(tabla);
    	if (resultado.length!=0){
    		$('#asistencia-pdf').removeAttr("disabled");
    	};
      },
      error:function(){
        console.log('Error');
      }
    });
 })

$(document).on('submit','#formulario-asistenciatot', function(event){
	event.preventDefault();
    $.ajax({
      type:"POST",
      data:"accion=5 &" + $(this).serialize(),
      url:"bd.php",
      success:function(r){
        resultado2=jQuery.parseJSON(r);
        var tabla2="";
        $('#asistenciatot-tabla').DataTable().clear();
        $('#asistenciatot-tabla').DataTable().draw();
        for (var i=0; i<resultado2.length; i+=1){
    		$('#asistenciatot-tabla').DataTable().row.add( [
			resultado2[i]["apellido"]+", "+resultado2[i]["nombre"],
			resultado2[i]["presente"]+"/"+resultado2[i]["total"],
			resultado2[i]["porcentaje"]
			] ).draw( false );
    		tabla2=tabla2+resultado2[i]["apellido"]+", "+resultado2[i]["nombre"]+"*"+resultado2[i]["presente"]+"/"+resultado2[i]["total"]+"*"+resultado2[i]["porcentaje"]+"!";
    	};
    	$('#asistenciatotpdf-finicio').val(document.getElementById("asistenciatot-finicio").value);
    	$('#asistenciatotpdf-ffin').val(document.getElementById("asistenciatot-ffin").value);
    	$('#asistenciatotpdf-tabla').val(tabla2);
    	if (resultado2.length!=0){
    		$('#asistenciatot-pdf').removeAttr("disabled");
    	};
      },
      error:function(){
        console.log('Error');
      }
    });
 })
</script>

<header>
	<nav class="navbar navbar-expand-lg bg-dark barramenu">
			<img class="img-responsive mr-2" src="imagen/logo.svg" alt="logo eg"/>
			<h5 class="navbar-brand text-white font-italic" id="energym">Energym</h5>
			<button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
			</button>
  		<div class="collapse navbar-collapse" id="navbarSupportedContent">
    		<ul class="navbar-nav mr-auto">
      			<li class="nav-item opciones1">
    				<a class="nav-link my-2" href="index.php"><button type="button" class="btn btn-primary botones1">Inicio</button></a>
    			</li>
      			<li class="nav-item opciones1">
        			<a class="nav-link my-2" href="noticias.php"><button type="button" class="btn btn-primary botones1">Noticias</button></a>
      			</li>
      			<li class="nav-item opciones1">
        			<a class="nav-link my-2" href="contacto.php"><button type="button" class="btn btn-primary botones1">Contacto</button></a>
      			</li>
    		</ul>
    		<form class="form-inline my-2">
      			<input class="form-control mr-sm-2" type="search" placeholder="Búsqueda" aria-label="Search">
      			<button class="btn btn-outline-success my-2" type="submit">Buscar</button>
    		</form>
  		</div>
	</nav>
</header>




<div class="card col-9 col-xl-10" id="asistencia-card" style="z-index: 10000000;">
	<div class="card-body">
		<h3 class="card-title text-center" id="asistencia-card-titulo">Informe de Asistencia</h3>
		<div class="btn-group btn-group-toggle mx-3 my-4" data-toggle="buttons">
		  <button class="btn btn-primary active" type="button" id="asistencia-diaxdiab">
		    <input type="radio" checked="true" id="asistencia-diaxdia"> Diarias
		  </button>
		  <button class="btn btn-primary" type="button" id="asistencia-totalesb">
		    <input type="radio" id="asistencia-totales"> Totales
		  </button>
		</div>
		<div id="divdiaxdia">
			<div class="dropdown-divider"></div>
			<div class="row my-3">
				<form id="formulario-asistencia" class="form-inline">
					<div class="form-group ml-4 my-1">
						<label for="asistencia-finicio" id="asistencia-lfinicio">Desde</label>
						<input class="form-control ml-2" type="date" id="asistencia-finicio" name="asistencia-finicio">
					</div>
					<div class="form-group mx-4 mx-lg-5 my-1">
						<label for="asistencia-ffin" id="asistencia-lffin">Hasta</label>
						<input class="form-control ml-2" type="date" id="asistencia-ffin" name="asistencia-ffin">
					</div>
					<button type="submit" class="btn btn-primary" id="asistencia-mostrar" name="asistencia-mostrar">Mostrar</button>
				</form>
				<div class="my-1" style="margin-left:27vw">
					<form action="asistenciapdf.php" method="post" target="_blank">
						<input type="hidden" id="asistenciapdf-finicio" name="asistenciapdf-finicio"/>
						<input type="hidden" id="asistenciapdf-ffin" name="asistenciapdf-ffin"/>
						<input type="hidden" id="asistenciapdf-tabla" name="asistenciapdf-tabla"/>
						<button type="submit" disabled="true" class="btn btn-dark" id="asistencia-pdf" name="asistencia-pdf">Generar PDF</button>
					</form>
				</div>
			</div>
			<div class="dropdown-divider mb-4"></div>
			<div class="table-responsive">
				<table class="table table-hover text-center" id="asistencia-tabla">
					<thead class="bg-dark" style="color:white; font-weight:bold;">
						<tr>
							<td>Sucursal</td>
							<td>Fecha</td>
							<td>Apellido y Nombre</td>
							<td>Presente</td>	
						</tr>
					</thead>
					<tfoot class="bg-primary" style="color:white; font-weight:bold;">
						<tr>
							<td>Sucursal</td>
							<td>Fecha</td>
							<td>Apellido y Nombre</td>
							<td>Presente</td>

						</tr>
					</tfoot>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
		<div id="divtotales">
			<div class="dropdown-divider"></div>
			<div class="row my-3">
				<form id="formulario-asistenciatot" class="form-inline">
					<div class="form-group ml-4 my-1">
						<label for="asistenciatot-finicio" id="asistenciatot-lfinicio">Desde</label>
						<input class="form-control ml-2" type="date" id="asistenciatot-finicio" name="asistenciatot-finicio">
					</div>
					<div class="form-group mx-4 mx-lg-5 my-1">
						<label for="asistenciatot-ffin" id="asistenciatot-lffin">Hasta</label>
						<input class="form-control ml-2" type="date" id="asistenciatot-ffin" name="asistenciatot-ffin">
					</div>
					<button type="submit" class="btn btn-primary" id="asistenciatot-mostrar" name="asistenciatot-mostrar">Mostrar</button>
				</form>
				<div class="my-1" style="margin-left:27vw">
					<form action="asistenciatotpdf.php" method="post" target="_blank">
						<input type="hidden" id="asistenciatotpdf-finicio" name="asistenciatotpdf-finicio"/>
						<input type="hidden" id="asistenciatotpdf-ffin" name="asistenciatotpdf-ffin"/>
						<input type="hidden" id="asistenciatotpdf-tabla" name="asistenciatotpdf-tabla"/>
						<button type="submit" disabled="true" class="btn btn-dark" id="asistenciatot-pdf" name="asistenciatot-pdf">Generar PDF</button>
					</form>
				</div>
			</div>
			<div class="dropdown-divider mb-4"></div>
			<div class="table-responsive">
				<table class="table table-hover text-center" id="asistenciatot-tabla">
					<thead class="bg-dark" style="color:white; font-weight:bold;">
						<tr>
							<td>Apellido y Nombre</td>
							<td>Presente/Total</td>
							<td>% Asistencia</td>
						</tr>
					</thead>
					<tfoot class="bg-primary" style="color:white; font-weight:bold;">
						<tr>
							<td>Apellido y Nombre</td>
							<td>Presente/Total</td>
							<td>% Asistencia</td>
						</tr>
					</tfoot>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>



<script type="text/javascript">
$(document).ready(function() {
    $('#asistencia-tabla').DataTable( {
        "order": [[0, "asc"], [1, "asc"], [2, "asc"]],
        "language": {
            "emptyTable": "Tabla vacía",
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No hay coincidencias con el criterio de búsqueda",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "infoEmpty": "No hay registros para mostrar",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Búsqueda:",
            "paginate": {
              "next": "Siguiente",
              "previous": "Anterior"
            }
        }
    } );
    $('#asistenciatot-tabla').DataTable( {
        "order": [[0, "asc"]],
        "language": {
            "emptyTable": "Tabla vacía",
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No hay coincidencias con el criterio de búsqueda",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "infoEmpty": "No hay registros para mostrar",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Búsqueda:",
            "paginate": {
              "next": "Siguiente",
              "previous": "Anterior"
            }
        }
    } );
    $('#divtotales').toggle();
} );
</script>
<style>img[alt="www.000webhost.com"]{display:none}</style>﻿
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>