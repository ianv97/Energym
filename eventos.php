<?php
session_start();
if (!isset($_SESSION["usuario"])) {header("Location: index.php");}
if ($_SESSION["nacceso"]<3) {header("Location: index.php");}
$db_host="localhost";
$db_usuario="id5245865_ianv97";
$db_clave="g7energymg7";
$db_nombre="id5245865_energym";
$conexion=new PDO("mysql:host=$db_host; dbname=$db_nombre","$db_usuario","$db_clave");
$conexion->exec("SET CHARACTER SET utf8");

if (isset($_POST['añadir-botonagregar'])){
	$titulo = $_POST['añadir-titulo'];
	$inicio = $_POST['añadir-inicio'];
	$fin  = $_POST['añadir-fin'];
	$descripcion = $_POST['añadir-descripcion'];
	$colorf = $_POST['añadir-colorf'];
	$colort = $_POST['añadir-colort'];
	$ingresos = $_POST['añadir-ingresos'];
	if (isset($_POST['añadir-liberado'])){
		$liberado = 1;
	}else{
		$liberado=0;
	};
	$qry="INSERT INTO Evento (titulo,inicio,fin,descripcion,colorf,colort,ingresos,liberado) VALUES(?,?,?,?,?,?,?,?)";
	$resultado=$conexion->prepare($qry);
	$resultado->execute(array($titulo,$inicio,$fin,$descripcion,$colorf,$colort,$ingresos,$liberado));
};

if (isset($_POST['editar-botonguardar'])){
	$titulo = $_POST['editar-titulo'];
	$inicio = $_POST['editar-inicio'];
	$fin  = $_POST['editar-fin'];
	$descripcion = $_POST['editar-descripcion'];
	$colorf = $_POST['editar-colorf'];
	$colort = $_POST['editar-colort'];
	$ingresos = $_POST['editar-ingresos'];
	if (isset($_POST['editar-liberado'])){
		$liberado = 1;
	}else{
		$liberado=0;
	};
	$id = $_POST['editar-id'];
	$qry="UPDATE Evento SET titulo=?,inicio=?,fin=?,descripcion=?,colorf=?,colort=?,ingresos=?,liberado=? WHERE id=?";
	$resultado=$conexion->prepare($qry);
	$resultado->execute(array($titulo,$inicio,$fin,$descripcion,$colorf,$colort,$ingresos,$liberado,$id));
};

if (isset($_POST['editar-botoneliminar'])){
	$qry="DELETE FROM Evento WHERE id=?";
	$resultado=$conexion->prepare($qry);
	$resultado->execute(array($_POST['editar-id']));
};
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <link rel='stylesheet' href='fullcalendar/fullcalendar.css' />
    <link rel='stylesheet' href="css/estilos.css">
    <link rel="shortcut icon" href="imagen/logo.ico"/>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script src='js/moment.js'></script>
    <script src='fullcalendar/fullcalendar.js'></script>
    <script src='fullcalendar/locale/es.js'></script>
    <title>Energym - Eventos</title>
    <style type="text/css">
	body {position:relative; background-image:url(imagen/fondo-perfil.jpg); z-index: 10000000;}
	.fc-content {cursor: pointer;}
	.fc-row {cursor: cell;}
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


<div class="card col-9 col-xl-10" id="eventos-card" style="z-index: 10000000;">
	<div class="card-body">
	    <div class="row">
			<div id='calendario'></div>
		</div>
	</div>
</div>



<div class="modal fade" id="modal-nuevoevento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="position:fixed; top:10%; right:15%; z-index: 10000004;">
    <div class="modal-dialog">
	    <div class="modal-content">
	        <div class="modal-header">
	        	<h4 class="modal-title" id="myModalLabel">Añadir nuevo evento</h4>
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          			<span aria-hidden="true">&times;</span>
        		</button>
	      	</div>
	      	<form action="" method="post">
	      		<div class="modal-body" style="background-image: url(https://energym.tk/imagen/fondo_formulario.jpg);">
		          	<label for="añadir-titulo" style="color:white; font-weight:bold;">Título</label>
		          	<input type="text" required autocomplete="off" name="añadir-titulo" class="form-control" id="añadir-titulo" placeholder="Introduce un título">
		          	<br>
		            <label for="añadir-inicio" style="color:white; font-weight:bold;">Inicio</label>
		            <input type='datetime-local' id="añadir-inicio" name="añadir-inicio" class="form-control"/>
		          	<br>
		          	<label for="añadir-fin" style="color:white; font-weight:bold;">Final</label>
		            <input type='datetime-local' name="añadir-fin" id="añadir-fin" class="form-control"/>
		          	<br>
		          	<label for="añadir-descripcion" style="color:white; font-weight:bold;">Descripción</label>
		          	<textarea id="añadir-descripcion" name="añadir-descripcion" required class="form-control" rows="3"></textarea>
		          	<br>
			        <label for="añadir-ingresos" class="ml-3" style="color:white; font-weight:bold;">Ingresos</label>
			        <div class="row ml-3">
			        	<div class="input-group mr-4" style="width:180px;">
							<div class="input-group-prepend">
						    	<span class="input-group-text">$</span>
						  	</div>
						  	<input type="number" class="form-control" id="añadir-ingresos" name="añadir-ingresos" aria-label="Ingresos" value="0">
						  	<div class="input-group-append">
						    	<span class="input-group-text">.00</span>
						  	</div>
						</div>
						<div class="btn-group-toggle ml-5" data-toggle="buttons">
							<label class="btn btn-warning active">
						    	<input type="checkbox" class="btn btn-warning" id="añadir-liberado" name="añadir-liberado" checked> Liberar ingreso
							</label>
						</div>
					</div>
		          	<br>
		          	<div class="row ml-3">
		          		<label for="añadir-colorf" style="color:white; font-weight:bold;">Color del fondo</label>
		            	<input type='color' name="añadir-colorf" class="ml-2 mr-5" id="añadir-colorf" value="#343a40"/>
		            	<label for="añadir-color" class="ml-5" style="color:white; font-weight:bold;">Color del texto</label>
		            	<input type='color' name="añadir-colort" class="ml-2" id="añadir-colort" value="#FFFFFF"/>
		        	</div>
	      		</div>
      			<div class="modal-footer bg-dark d-flex justify-content-center">
        			<button type="submit" class="btn btn-primary" id="añadir-botonagregar" name="añadir-botonagregar" style="font-weight:bold;"><i class="fa fa-plus-square"></i> Añadir</button>
        		</div>
    		</form>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-editarevento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="position:fixed; top:10%; right:15%; z-index:10000004">
    <div class="modal-dialog">
	    <div class="modal-content">
	        <div class="modal-header">
	        	<h4 class="modal-title" id="myModalLabel">Editar evento</h4>
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          			<span aria-hidden="true">&times;</span>
        		</button>
	      	</div>
	      	<form action="" method="post" id="evento-formulario">
	      		<div class="modal-body" style="background-image: url(https://energym.tk/imagen/fondo_formulario.jpg);">
	      			<input type="text" hidden="true" id="editar-id" name="editar-id"/>
	      			<label for="editar-titulo" style="color:white; font-weight:bold;">Título</label>
		          	<input type="text" required autocomplete="off" name="editar-titulo" class="form-control" id="editar-titulo" placeholder="Introduce un título">
		          	<br>
		            <label for="editar-inicio" style="color:white; font-weight:bold;">Inicio</label>
		            <input type='datetime-local' id="editar-inicio" name="editar-inicio" class="form-control"/>
		          	<br>
		          	<label for="editar-fin" style="color:white; font-weight:bold;">Final</label>
		            <input type='datetime-local' name="editar-fin" id="editar-fin" class="form-control"/>
		          	<br>
		          	<label for="editar-descripcion" style="color:white; font-weight:bold;">Descripción</label>
		          	<textarea id="editar-descripcion" name="editar-descripcion" required class="form-control" rows="3"></textarea>
		          	<br>
			        <label class="ml-3" for="editar-ingresos" style="color:white; font-weight:bold;">Ingresos</label>
			        <div class="row ml-3">
			        	<div class="input-group mr-4" style="width:180px;">
							<div class="input-group-prepend">
						    	<span class="input-group-text">$</span>
						  	</div>
						  	<input type="number" class="form-control" id="editar-ingresos" name="editar-ingresos" aria-label="Ingresos">
						  	<div class="input-group-append">
						    	<span class="input-group-text">.00</span>
						  	</div>
						</div>
						<div class="btn-group-toggle ml-5" data-toggle="buttons">
							<label class="btn btn-warning">
						    	<input type="checkbox" id="editar-liberado" name="editar-liberado"> Liberar ingreso
							</label>
						</div>
					</div>
		          	<br><br>
		          	<div class="row ml-3">
		          		<label for="añadir-colorf" style="color:white; font-weight:bold;">Color del fondo</label>
		            	<input type='color' name="editar-colorf" class="ml-2 mr-5" id="editar-colorf"/>
		            	<label for="añadir-color" class="ml-5" style="color:white; font-weight:bold;">Color del texto</label>
		            	<input type='color' name="editar-colort" class="ml-2" id="editar-colort"/>
		        	</div>
	      		</div>
      			<div class="modal-footer bg-dark">
      				<div style="margin-right:260px;">
        				<button type="button" class="btn btn-danger" id="popover-eliminar"><i class="fa fa-times"></i> Eliminar</button>
        			</div>
        			<button type="submit" class="btn btn-success" id="editar-botonguardar" name="editar-botonguardar"><i class="fa fa-check"></i> Guardar</button>
        		</div>
    		</form>
		</div>
	</div>
</div>



<script type="text/javascript">
$(document).ready(function(){
    $('#calendario').fullCalendar({
        aspectRatio: 1,
        height: 550,
        themeSystem: 'bootstrap4',
        header: {
          left: 'month,agendaWeek,agendaDay,listMonth',
          center: 'title',
          right: 'prev,today,next'
        },
        titleFormat: 'MMMM YYYY',
        weekNumbers: true,
        weekends: true,
        fixedWeekCount: false,
        minTime: "08:00:00",
        time_split: '30',
	    events: [
	        <?php
	        $qry="SELECT * FROM Evento";
	        $resultado=$conexion->prepare($qry);
	        $resultado->execute();
	        $row=$resultado->fetch(PDO::FETCH_ASSOC);
	        while ($row) {?>
	        {
	        	id:"<?php echo $row["id"];?>",
	            title:"<?php echo $row["titulo"];?>",
	            start:"<?php echo $row["inicio"];?>",
	            end:"<?php echo $row["fin"];?>",
	            description:`<?php echo $row["descripcion"];?>`,
	            color:"<?php echo $row["colorf"];?>",
	            textColor:"<?php echo $row["colort"];?>",
	            ingresos:"<?php echo $row["ingresos"];?>",
	            liberado:"<?php echo $row["liberado"];?>"
	        },
	        <?php
	        $row=$resultado->fetch(PDO::FETCH_ASSOC);
	        };?>
	    ],
	    dayClick: function(date,jsEvent,view){
        	$("#modal-nuevoevento").modal();
        	$("#añadir-inicio").val(moment(date).format('YYYY-MM-DD')+"T08:00");
        	$("#añadir-fin").val(moment(date).format('YYYY-MM-DD')+"T23:59");
        },
        eventClick: function(calEvent,jsEvent,view){
        	$("#editar-id").val(calEvent.id);
        	$("#editar-titulo").val(calEvent.title);
        	$("#editar-inicio").val(moment(calEvent.start).format('YYYY-MM-DD')+"T"+moment(calEvent.start).format('HH:mm'));
        	$("#editar-fin").val(moment(calEvent.end).format('YYYY-MM-DD')+"T"+moment(calEvent.end).format('HH:mm'));
        	$("#editar-descripcion").html(calEvent.description);
        	$("#editar-colorf").val(calEvent.color);
        	$("#editar-colort").val(calEvent.textColor);
        	$("#editar-ingresos").val(calEvent.ingresos);
        	$("#modal-editarevento").modal();
        	if (calEvent.liberado==1 && $("#editar-liberado").prop("checked")==false){
        		$("#editar-liberado").click();
        		$("#editar-liberado").prop("checked",true);
        	}else{
        		if (calEvent.liberado==0 && $("#editar-liberado").prop("checked")==true){
        			$("#editar-liberado").click();
        			$("#editar-liberado").prop("checked",false);
        		};
        	};
        }
  })
  });
</script>
<style type="text/css">.popover {z-index: 10000006;}</style>
<script>
$(document).ready(function(){
    $('#popover-eliminar').popover({
    	title: "<div class='d-flex justify-content-center'><label>Está por eliminar un evento ¿Desea continuar?</label></div>",
    	content: "<div class='d-flex justify-content-center'><button type='submit' form='evento-formulario' class='btn btn-warning' name='editar-botoneliminar'>Confirmar</button></div>",
    	html: true,
    	placement: "right"}); 
});
</script>

<style>img[alt="www.000webhost.com"]{display:none}</style>﻿
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>