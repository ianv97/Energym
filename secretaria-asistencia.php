<?php
	session_start();
	if (!isset($_SESSION["usuario"])) {header("Location: index.php");}
	if ($_SESSION["nacceso"]!=2) {header("Location: index.php");}
	$db_host="localhost";
	$db_usuario="id5245865_ianv97";
	$db_clave="g7energymg7";
	$db_nombre="id5245865_energym";
	$conexion=new PDO("mysql:host=$db_host; dbname=$db_nombre","$db_usuario","$db_clave");
	$conexion->exec("SET CHARACTER SET utf8");
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="shortcut icon" href="imagen/logo.ico"/>
  <link rel='stylesheet' href="css/estilos.css">
	<link rel="shortcut icon" href="imagen/logo.ico"/>
	<script type="text/javascript" src="js/jquery.js"></script>
	<title>Energym - Registrar asistencia</title>
</head>

<style type="text/css">
body {background-image:url(https://energym.tk/imagen/fondo-perfil.jpg);}
.inputcentro::-webkit-input-placeholder{text-align:center;}
.inputcentro{text-align:center;}
</style>

<?php
if (!isset($_SESSION["usuario"])) {require "sidebar.php";
}else{
  switch($_SESSION["nacceso"]) {
    case 0: require "sidebar-usuario.php";break;
    case 1: require "sidebar-profesor.php";break;
    case 2: require "sidebar-secretaria.php";break;
    case 3: require "sidebar-administradora.php";break;
    case 4: require "sidebar-gerente.php";break;
  };
};

if (isset($_POST["regasistencia-boton"])){ 
	$usuario=$_POST["asist_usuario"];
	if ($_POST["asist_nivel_acceso"]==0){
		$qry="SELECT id_asistencia FROM Asistencia WHERE usuario=? AND fecha=curdate()";
		$resultado=$conexion->prepare($qry);
	    $resultado->execute(array($usuario));
	    $row=$resultado->fetch(PDO::FETCH_ASSOC);
	    if (empty($row['id_asistencia'])){
			$qry="INSERT INTO Asistencia (fecha,presente,sucursal,usuario) VALUES (curdate(),1,?,?)";
			$resultado=$conexion->prepare($qry);
	      	$resultado->execute(array((int)$_SESSION["sucursal"],$usuario));
	    };
	}else{
		$qry="SELECT id_asistencia FROM AsistenciaEmpleado WHERE usuario=? AND fecha=curdate()";
		$resultado=$conexion->prepare($qry);
	    $resultado->execute(array($usuario));
	    $row=$resultado->fetch(PDO::FETCH_ASSOC);
	    if (empty($row['id_asistencia'])){
			$qry="INSERT INTO AsistenciaEmpleado (fecha,presente,horaingreso,sucursal,usuario) VALUES (curdate(),1,curtime(),?,?)";
			$resultado=$conexion->prepare($qry);
	      	$resultado->execute(array($_SESSION["sucursal"],$usuario));
	    }else{
	    	$qry="UPDATE AsistenciaEmpleado SET horasalida=curtime() WHERE id_asistencia=?";
	    	$resultado=$conexion->prepare($qry);
	      	$resultado->execute(array($row["id_asistencia"]));
	    };
	};
};

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

<body>
<div class="col-10 px-0 mx-0"  style="margin-top:35vh;">
	<div class="text-warning d-flex justify-content-center mx-0 my-3">
		<h1 id="regasistencia-titulo">Registrar asistencia</h1>
	</div>
	<div class="d-flex justify-content-center">
		<div class="row my-3">
			<div class="input-group input-group-large" id="regasistencia-usuariodnic">
				<input type="text" class="form-control inputcentro" name="regasistencia-usuariodni" placeholder="Usuario o DNI" id="regasistencia-usuariodni">
			</div>
		</div>
	</div>
	<div class="d-flex justify-content-center">
		<div class="row my-2">
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#regasistencia-modal" onclick="registrarAsistencia()">Verificar</button>
		</div>
	</div>
</div>


<div class="modal fade" id="regasistencia-modal" tabindex="-1" role="dialog" style="z-index:10000004">
	<div class="modal-dialog" role="document">
		<div class="modal-content" style="margin-top:15vh; margin-left:-6vw;">
			<div class="modal-header">
				<h5 class="modal-title">Registrar asistencia</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style="background-image: url(https://energym.tk/imagen/fondo_formulario.jpg);">
				<form method="post" action="" enctype="multipart/form-data" id="regasistencia-formulario">
					<div class="input-group input-group-large mb-2 d-flex justify-content-center">
						<img src="Uploads/anonimo.jpg" class="recuadro" id="regasistencia-foto" name="regasistencia-foto"/>
					</div>
					<div class="row d-flex justify-content-center">
						<div class="input-group input-group-large mt-4 mb-2" id="regasistencia-usuarioc">
							<input disabled="disabled" id="regasistencia-usuario" class="form-control inputcentro" name="regasistencia-usuario" placeholder="Usuario" aria-label="Usuario">
						</div>
					</div>
					<div class="row d-flex justify-content-center">
						<div class="input-group input-group-large my-2" id="regasistencia-nyac">
							<input disabled="disabled" type="text" id="regasistencia-nya" class="form-control inputcentro" name="regasistencia-nya" placeholder="Apellido y Nombre" aria-label="Apellido y Nombre">
						</div>
					</div>
					<div class="row d-flex justify-content-center">
						<div class="input-group input-group-large my-2" id="regasistencia-dnic">
							<input disabled="disabled" type="text" id="regasistencia-dni" class="form-control inputcentro" name="regasistencia-dni" placeholder="DNI" aria-label="DNI">
						</div>
					</div>
					<input type="hidden" name="asist_nivel_acceso" id="asist_nivel_acceso">
					<input type="hidden" name="asist_usuario" id="asist_usuario">
				</form>
			</div>
			<div class="modal-footer bg-dark d-flex justify-content-center">
				<button disabled="disabled" type="submit" form="regasistencia-formulario" class="btn btn-primary" id="regasistencia-boton" name="regasistencia-boton" style="font-weight:bold;">Registrar asistencia</button>
			</div>
		</div>
	</div>
</div>

</body>

<script type="text/javascript">
  function registrarAsistencia(){
    var usuario = $('#regasistencia-usuariodni').val();
    $.ajax({
      type:"POST",
      data:"accion=9 & usuario_d=" + usuario,
      url:"bd.php",
      success:function(r){
        datos=jQuery.parseJSON(r);
        if ($.isEmptyObject(datos)){
        	$('#regasistencia-boton').attr("disabled","disabled");
        }else{
        	$('#regasistencia-boton').removeAttr("disabled");
    	};
        if ($.isEmptyObject(datos['foto'])){
            $('#regasistencia-foto').attr("src","Uploads/anonimo.jpg");
        }else{
            $('#regasistencia-foto').attr("src","Uploads/"+datos['foto']);
        };
        $('#regasistencia-usuario').val(datos['usuario']);
        $('#regasistencia-nya').val(datos['apellido']+', '+datos['nombre']);
        $('#regasistencia-dni').val(datos['dni']);
    	$('#asist_usuario').val(datos['usuario']);
    	$('#asist_nivel_acceso').val(datos['nivel_acceso']);
      }
    });
  };
</script>
<style>img[alt="www.000webhost.com"]{display:none}</style>﻿
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

