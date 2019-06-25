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
	<link rel="shortcut icon" href="imagen/logo.ico"/>
	<script type="text/javascript" src="js/jquery.js"></script>
	<title>Energym - Contacto</title>
	<style type="text/css">
		body {position:relative; background-image:url(imagen/fondo_formulario2.jpg); z-index: 10000000;}
	</style>
</head>

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

<body>
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
        			<a class="nav-link my-2" href="contacto.php"><button type="button" class="btn active btn-primary bg-warning botones1">Contacto</button></a>
      			</li>
    		</ul>
    		<form class="form-inline my-2">
      			<input class="form-control mr-sm-2" type="search" placeholder="Búsqueda" aria-label="Search">
      			<button class="btn btn-outline-success my-2" type="submit">Buscar</button>
    		</form>
  		</div>
	</nav>
</header>

<section>
	<div class="jumbotron jumbotron-fluid bg-warning py-3">
			<div class="container">
			<h1 class="align-middle" id="contacto-titulo">Contáctenos</h1>
			<img class="align-top" id="contacto-titulo-imagen" src="imagen/contactenos.svg" alt="contactenos"/> 
			</div>
	</div>
	<article>
			<form method="post" action="">
				<div class="input-group input-group-large my-0" id="contacto-nombre">
					<input type="text" class="form-control" placeholder="Nombre" aria-label="Nombre">
				</div>
				<div class="input-group input-group-large my-0" id="contacto-apellido">
					<input type="text" class="form-control" placeholder="Apellido" aria-label="Apellido">
				</div>
				<div class="input-group input-group-large my-4" id="contacto-email">
					<input type="email" class="form-control" placeholder="E-mail" aria-label="E-mail">
				</div>
				<div class="input-group input-group-large my-4" id="contacto-asunto">
					<input type="text" class="form-control" placeholder="Asunto" aria-label="Asunto">
				</div>
				<div class="input-group input-group-lg my-4" id="contacto-mensaje">
						<div class="input-group-prepend">
						<span class="input-group-text px-1 px-xl-3" style="font-weight:bold; font-size: 1vw;">Mensaje</span>
						</div>
						<textarea class="form-control" aria-label="Mensaje"></textarea>
				</div>
				<button type="submit" class="btn btn-primary btn-lg" id="contacto-boton-envio">Enviar</button>
			</form>
	</article>
</section>
<style>img[alt="www.000webhost.com"]{display:none}</style>﻿
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>