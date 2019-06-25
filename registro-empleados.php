<?php
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel='stylesheet' href="css/estilos.css">
    <link rel='stylesheet' href="css/estilos-secretaria.css">
	<link rel="shortcut icon" href="imagen/logo.ico"/>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/datatable3.js"></script>
	<script type="text/javascript" src="js/datatable4.js"></script>
	<script type="text/javascript" src="js/datatable5.js"></script>
	<title>Energym - Inicio</title>
</head>

<body class="bodyGerente" style="background-color: white">

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
    
    if (isset($_POST["registro-boton-envio"])){
$db_host="localhost";
$db_usuario="id5245865_ianv97";
$db_clave="g7energymg7";
$db_nombre="id5245865_energym";

try {
	$conexion=new PDO("mysql:host=$db_host; dbname=$db_nombre","$db_usuario","$db_clave");
	$conexion->exec("SET CHARACTER SET utf8");
	empty($_POST["registro-usuario"])? $usuario="nulo" : $usuario=$_POST["registro-usuario"];
	empty($_POST["registro-contraseña"])? $contraseña="nulo" : $contraseña=$_POST["registro-contraseña"];
	empty($_POST["registro-confcontraseña"])? $confcontraseña="nulo" : $confcontraseña=$_POST["registro-confcontraseña"];
	empty($_POST["registro-email"])? $email="nulo" : $email=$_POST["registro-email"];
	empty($_POST["registro-nombre"])? $nombre="nulo" : $nombre=$_POST["registro-nombre"];
	empty($_POST["registro-apellido"])? $apellido="nulo" : $apellido=$_POST["registro-apellido"];
	empty($_POST["registro-fecha-nac"])? $fecha_nac="nulo" : $fecha_nac=$_POST["registro-fecha-nac"];
	empty($_POST["registro-dni"])? $dni="nulo" : $dni=$_POST["registro-dni"];
	isset($_POST["registro-sexo"])? $sexo=$_POST["registro-sexo"] : $sexo="nulo";
	isset($_POST["registro-recibir-info"])?	$recibir_info=1 : $recibir_info=0;
	($_FILES['registro-foto']['error'])==0? $estado_foto="adjuntada" : $estado_foto="nulo";
	
	$nombre_foto='';
	if ($usuario!="nulo" && $contraseña!="nulo" && $confcontraseña!="nulo" && $email!="nulo" && $nombre!="nulo" && $apellido!="nulo" && $fecha_nac!="nulo" && $dni!="nulo"&& $sexo!="nulo" && $aceptar_condiciones!="nulo"){
		if ($contraseña!=$confcontraseña) {
			echo "<script> alert('Los campos contraseña y confirmar contraseña no coinciden.')</script>";
		}else{
			if ($estado_foto=="adjuntada") {
				$tamaño_foto=$_FILES ['registro-foto']['size'];
				if ($tamaño_foto<=3000000) {
					$tipo_foto=$_FILES ['registro-foto']['type'];
					if ($tipo_foto=='image/jpg'||$tipo_foto=='image/jpeg'||$tipo_foto=='image/png'||$tipo_foto=='image/gif'){
						$destino=$_SERVER['DOCUMENT_ROOT'] . '/Uploads/';
						$nombre_foto=$_FILES ['registro-foto']['name'];
						move_uploaded_file($_FILES['registro-foto']['tmp_name'], $destino.$nombre_foto);
					}else{
						echo "<script> alert('La imagen debe estar en formato jpg, jpeg, png o gif')</script>";
					}
				}else{
					echo "<script> alert('El tamaño de la imagen excede el límite de 3 MB')</script>";
				}
			}
			$contraseña=password_hash($contraseña,PASSWORD_DEFAULT);
			$qry="INSERT INTO Usuario (usuario,contraseña,email,nombre,apellido,fecha_nac,sexo,recibir_info,foto,dni) VALUES (?,?,?,?,?,?,?,?,?,?)";
			$resultado=$conexion->prepare($qry);
			$resultado->execute(array($usuario,$contraseña,$email,$nombre,$apellido,$fecha_nac,$sexo,$recibir_info,$nombre_foto,$dni));
			if (($resultado->errorCode())!='00000'){
				echo "<script> alert('¡Error en la consulta a la BD!')</script>";
			}else{
				echo "<script> alert('¡Usuario registrado con éxito!')</script>";
			}
			$resultado->closeCursor();
		}
	}else{
		if ($usuario=="nulo" || $contraseña=="nulo" || $email=="nulo" || $nombre=="nulo" || $apellido=="nulo"|| $fecha_nac=="nulo" || $sexo=="nulo" || $dni=="nulo") {echo "<script> alert ('Debe rellenar todos los campos obligatorios.')</script>";}
		if ($aceptar_condiciones=="nulo"){echo "<script> alert('Debe aceptar los términos y condiciones.')</script>";}
	}

}catch(Exception $e){
	echo "<script> alert('Error al conectar con la Base de datos.')</script>";
}

}
?>


<header>
	<nav class="navbar navbar-expand-lg bg-dark barramenu secretaria">
			<img class="img-responsive mr-2" src="imagen/logo.svg" alt="logo eg"/>
			<h5 class="navbar-brand text-white font-italic" id="energym">Energym</h5>
			<button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
			</button>
  		<div class="collapse navbar-collapse" id="navbarSupportedContent" style="float: right;">
    		<form class="form-inline my-2">
      			<input class="form-control mr-sm-2" type="search" placeholder="Búsqueda" aria-label="Search">
      			<button class="btn btn-outline-success my-2" type="submit">Buscar</button>
    		</form>
  		</div>
	</nav>
</header>

<section id="registro-formulario">
	<div class="jumbotron jumbotron-fluid bg-warning py-3">
			<div class="container" id="registro-jumbo">
			<h1 class="align-middle" id="registro-titulo">Registrar Empleado</h1>
			<img class="align-top" id="registro-titulo-imagen" src="imagen/registro.png" alt="registro"/> 
			</div>
	</div>
	<article>
			<form method="post" action="" enctype="multipart/for-data">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                      <label class="btn btn-secondary active" style="margin-left: 10vw;font-size:20px;font-weight:bold;">
                        <input type="radio" name="options" id="option1" autocomplete="off" checked> Profesor/a
                      </label> 
                      <label class="btn btn-secondary" style="font-size:20px;font-weight:bold;">
                        <input type="radio" name="options" id="option2" autocomplete="off"> Secretario/a
                      </label>
                      <label class="btn btn-secondary" style="font-size:20px;font-weight:bold;">
                        <input type="radio" name="options" id="option3" autocomplete="off"> Administración
                      </label>
                      <label class="btn btn-secondary" style="font-size:20px;font-weight:bold;">
                        <input type="radio" name="options" id="option4" autocomplete="off"> Director/a
                      </label>
                </div>
				<div class="input-group input-group-large my-4" id="registro-usuario">
					<input type="text" class="form-control" name="registro-usuario" placeholder="Usuario" aria-label="Usuario">
				</div>
				<div class="input-group input-group-large my-4" id="registro-contraseña">
					<input type="password" class="form-control" name="registro-contraseña" placeholder="Contraseña" aria-label="Contraseña">
				</div>
				<div class="input-group input-group-large my-4" id="registro-confcontraseña">
					<input type="password" class="form-control" name="registro-confcontraseña" placeholder="Repetir Contraseña" aria-label="Repetir Contraseña">
				</div>
				<div class="input-group input-group-large my-4" id="registro-email">
					<input type="email" class="form-control" name="registro-email" placeholder="E-mail" aria-label="E-mail">
				</div>
				<div class="input-group input-group-large my-0" id="registro-nombre">
					<input type="text" class="form-control" name="registro-nombre" placeholder="Nombre" aria-label="Nombre">
				</div>
				<div class="input-group input-group-large my-4 my-md-0 mx-5 mx-sm-3" id="registro-apellido">
					<input type="text" class="form-control" name="registro-apellido" placeholder="Apellido" aria-label="Apellido">
				</div>
				<div class="mt-5" id="registro-fecha-nac">
					<label id="registro-lfecha-nac">Fecha de nacimiento</label>
					<input type="date" class="form-control" name="registro-fecha-nac" aria-label="Fecha de Naciemiento">
				</div>
				<div class="input-group input-group-large mt-1 mb-4" id="registro-dni">
					<input type="text" class="form-control" name="registro-dni" placeholder="DNI" aria-label="DNI">
				</div>
				<div class="custom-control custom-radio custom-control-inline mt-0 mb-3" id="registro-sexom">
						<input type="radio" value="M" id="customRadioInline1" name="registro-sexo" class="custom-control-input">
						<label class="custom-control-label" for="customRadioInline1">Hombre</label>
				</div>
				<div class="custom-control custom-radio custom-control-inline mt-0 mb-3" id="registro-sexof">
						<input type="radio" value="F" id="customRadioInline2" name="registro-sexo" class="custom-control-input">
						<label class="custom-control-label" for="customRadioInline2">Mujer</label>
				</div>
				<div class="form-group" id="contenedor-foto">
					<label for="registro-foto" style="margin-top: 1vw">Foto de Perfil (opcional)</label>
					<input type="file" class="form-control-file" id="registro-foto" name="registro-foto">
				</div>
				<button type="submit" class="btn btn-primary btn-lg" name="registro-boton-envio" id="registro-boton-envio">Registrar</but>
			</form>
	</article>
</section>


    

<style>img[alt="www.000webhost.com"]{display:none}</style>﻿
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


    </body>
</html>
