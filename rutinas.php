<?php
session_start();
if (!isset($_SESSION["usuario"])) {header("Location: index.php");}
if($_SESSION["nacceso"]==2) {header("Location: secretaria.php");}
if ($_SESSION["nacceso"]!=0) {header("Location: index.php");}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="shortcut icon" href="imagen/logo.ico"/>
	<link rel="stylesheet" href="css/datatable1.css">
	<link rel="stylesheet" href="css/datatable2.css">
	<link rel='stylesheet' href="css/estilos.css">
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/datatable3.js"></script>
	<script type="text/javascript" src="js/datatable4.js"></script>
	<script type="text/javascript" src="js/datatable5.js"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/all.js" integrity="sha384-xymdQtn1n3lH2wcu0qhcdaOpQwyoarkgLVxC/wZ5q7h9gHtxICrpcaSUfygqZGOe" crossorigin="anonymous"></script>
	<title>Energym - Rutinas</title>
	<style type="text/css">
	body {position:relative; background-image:url(imagen/fondo-perfil.jpg); z-index: 10000000;}
  	</style>
</head>
<body>

<?php
require "sidebar-usuario.php";
?>

<script type="text/javascript">
  function ver_ej(usuario_r, id_r){
    $.ajax({
      type:"POST",
      data:"accion=2 & usuario_r="+usuario_r+" & id_r="+id_r,
      url:"bd.php",
      success:function(r){
        datos=jQuery.parseJSON(r);
        $('#titulomodal').text("Ejercicios de " + datos['nombre_categoría']);
        if (datos['ejercicio1r']!=null){
        	$('#nej1').text(datos['ejercicio1']);
        	$('#sej1').val(datos['ejercicio1s']);
        	$('#rej1').val(datos['ejercicio1r']);
        	$('#f1').show();
        }else{
        	$('#f1').hide();
        };
        if (datos['ejercicio2r']!=null){
        	$('#nej2').text(datos['ejercicio2']);
        	$('#sej2').val(datos['ejercicio2s']);
        	$('#rej2').val(datos['ejercicio2r']);
        	$('#f2').show();
        }else{
        	$('#f2').hide();
        };
        if (datos['ejercicio3r']!=null){
        	$('#nej3').text(datos['ejercicio3']);
        	$('#sej3').val(datos['ejercicio3s']);
        	$('#rej3').val(datos['ejercicio3r']);
        	$('#f3').show();
        }else{
        	$('#f3').hide();
        };
        if (datos['ejercicio4r']!=null){
        	$('#nej4').text(datos['ejercicio4']);
        	$('#sej4').val(datos['ejercicio4s']);
        	$('#rej4').val(datos['ejercicio4r']);
        	$('#f4').show();
        }else{
        	$('#f4').hide();
        };
        if (datos['ejercicio5r']!=null){
        	$('#nej5').text(datos['ejercicio5']);
        	$('#sej5').val(datos['ejercicio5s']);
        	$('#rej5').val(datos['ejercicio5r']);
        	$('#f5').show();
        }else{
        	$('#f5').hide();
        };
        if (datos['ejercicio6r']!=null){
        	$('#nej6').text(datos['ejercicio6']);
        	$('#sej6').val(datos['ejercicio6s']);
        	$('#rej6').val(datos['ejercicio6r']);
        	$('#f6').show();
        }else{
        	$('#f6').hide();
        };
      },
      error:function(){
        console.log('Error');
      }
    });
 }
</script>

<?php
$db_host="localhost";
$db_usuario="id5245865_ianv97";
$db_clave="g7energymg7";
$db_nombre="id5245865_energym";
$conexion=new PDO("mysql:host=$db_host; dbname=$db_nombre","$db_usuario","$db_clave");
$conexion->exec("SET CHARACTER SET utf8");
$usuario=$_SESSION["usuario"];
$qry="SELECT usuario_rutina, id_rutina, fecha_inicio, fecha_fin, nombre, apellido, dia_rutina, nombre_categoría FROM Rutina
INNER JOIN Usuario ON Rutina.profesor=Usuario.usuario
INNER JOIN Categoría ON Rutina.categoría=id_categoría
WHERE usuario_rutina=?";
$resultado=$conexion->prepare($qry);
$resultado->execute(array($usuario));
?>
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

<div class="card col-9 col-xl-10" id="rutinas-card" style="z-index: 10000000;">
	<div class="card-body">
		<h5 class="card-title text-center" id="rutinas-card-titulo">Rutinas</h5>
		<div class="row">
	    	<label style="font-weight:bold; font-size:20px;" class="align-top ml-4 mr-1">Mostrar rutinas finalizadas</label>
	    	<label class="switch" onclick="cambiarfiltro()">
				<input form="registro-formulario" type="checkbox" id="checkfiltro" name="checkfiltro">
				<span class="slider round" onclick="cambiarfiltro()"></span>
			</label>
		</div>
		<div class="table-responsive">
			<table class="table table-hover text-center" id="rutinas-tabla">
				<thead class="bg-dark" style="color:white; font-weight:bold;">
					<tr>
						<td>Fecha de Inicio</td>
						<td>Fecha de Fin</td>
						<td>Día asignado</td>
						<td>Categoría</td>
						<td>Profesor</td>
						<td>Ejercicios</td>
					</tr>
				</thead>
				<tfoot class="bg-primary" style="color:white; font-weight:bold;">
					<tr>
						<td>Fecha de Inicio</td>
						<td>Fecha de Fin</td>
						<td>Día asignado</td>
						<td>Categoría</td>
						<td>Profesor</td>
						<td>Ejercicios</td>
					</tr>
				</tfoot>
				<tbody>
					<?php
					while ($row=$resultado->fetch(PDO::FETCH_BOTH)) {
						?>
						<tr>
							<td><?php echo $row['fecha_inicio'] ?></td>
							<td><?php if(empty($row['fecha_fin'])){echo "_";}else{echo $row['fecha_fin'];}; ?></td>
							<td><?php echo $row['dia_rutina'] ?></td>
							<td><?php echo $row['nombre_categoría'] ?></td>
							<td><?php echo $row['nombre'].' '.$row['apellido'] ?></td>
							<td>
								<span class="btn btn-warning" data-toggle="modal" data-target="#verejercicios" onclick="ver_ej('<?php echo $row[0] ?>',<?php echo $row[1] ?>)">
									<i class="fas fa-eye fa-lg"></i>
								</span>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- Ventana Modal -->
<div class="modal fade" id="verejercicios" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 10000004;">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="titulomodal"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style="background-image: url(https://energym.tk/imagen/fondo_formulario.jpg);">
				<div class="row ">
					<label class="subtmod col-4 ml-5" id="ejmod" style="color:white;">Ejercicio</label>
					<label class="subtmod col-2 ml-4" style="color:white;">Series</label>
					<label class="subtmod col-2 ml-4" style="color:white;">Repeticiones</label>
				</div>
				<div class="row align-middle" id="f1">
					<label id="nej1" class="nom col-5" style="color:white;"></label>
					<label class="col-3"><input type="text" class="form-control mx-3 ser" id="sej1" name="sej1" disabled=""></label>
					<label class="col-3"><input type="text" class="form-control mx-3 rep" id="rej1" name="rej1" disabled=""></label>
				</div>
				<div class="row align-middle" id="f2">
					<label id="nej2" class="nom col-5" style="color:white;"></label>
					<label class="col-3"><input type="text" class="form-control mx-3 ser" id="sej2" name="sej2" disabled=""></label>
					<label class="col-3"><input type="text" class="form-control mx-3 rep" id="rej2" name="rej2" disabled=""></label>
				</div>
				<div class="row align-middle" id="f3">
					<label id="nej3" class="nom col-5" style="color:white;"></label>
					<label class="col-3"><input type="text" class="form-control mx-3 ser" id="sej3" name="sej3" disabled=""></label>
					<label class="col-3"><input type="text" class="form-control mx-3 rep" id="rej3" name="rej3" disabled=""></label>
				</div>
				<div class="row align-middle" id="f4">
					<label id="nej4" class="nom col-5" style="color:white;"></label>
					<label class="col-3"><input type="text" class="form-control mx-3 ser" id="sej4" name="sej4" disabled=""></label>
					<label class="col-3"><input type="text" class="form-control mx-3 rep" id="rej4" name="rej4" disabled=""></label>
				</div>
				<div class="row align-middle" id="f5">
					<label id="nej5" class="nom col-5" style="color:white;"></label>
					<label class="col-3"><input type="text" class="form-control mx-3 ser" id="sej5" name="sej5" disabled=""></label>
					<label class="col-3"><input type="text" class="form-control mx-3 rep" id="rej5" name="rej5" disabled=""></label>
				</div>
				<div class="row align-middle" id="f6">
					<label id="nej6" class="nom  col-5" style="color:white;"></label>
					<label class="col-3"><input type="text" class="form-control mx-3 ser" id="sej6" name="sej6" disabled=""></label>
					<label class="col-3"><input type="text" class="form-control mx-3 rep" id="rej6" name="rej6" disabled=""></label>
				</div> 
			</div>
			<div class="modal-footer bg-dark d-flex justify-content-center">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
var tabla;
$(document).ready(function() {
    tabla=$('#rutinas-tabla').DataTable( {
        "order": [[ 0, "desc" ]],
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
    cambiarfiltro();
} );

function cambiarfiltro(){
	if ($('#checkfiltro').is(":checked")){
		tabla.columns(1).visible(true);
		tabla.column(1).search(' ');
		tabla.draw();
	}else{
		tabla.columns(1).visible(false);
		tabla.column(1).search('_');
		tabla.draw();
	};
};
</script>

<style type="text/css">

.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}
.switch input {display:none;}
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}
.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}
input:checked + .slider {
  background-color: #2196F3;
}
input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}
input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}
.slider.round {
  border-radius: 34px;
}
.slider.round:before {
  border-radius: 50%;
}
</style>

</body>

<style>img[alt="www.000webhost.com"]{display:none}</style>﻿
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</html>