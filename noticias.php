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
	<title>Energym - Noticias</title>
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
        			<a class="nav-link my-2" href="noticias.php"><button type="button" class="btn active btn-primary bg-warning botones1">Noticias</button></a>
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

<section class="container-fluid">
	<div class="row ml-1 ml-xl-2">
		<article class="card border-primary col-8 col-lg-4 col-xl-3 mx-1 mx-xl-2 mt-3 mb-2">
			<img class="card-img-top" src="imagen/suplementos.png" alt="Card image cap">
			<div class="card-body">
				<h3 class="card-title">Suplementos deportivos</h3>
	    		<p class="card-text text-justify">Expertos en sumplementos deportivos darán una charla informativa gratuita el día Miércoles 8 de Agosto a las 19:00 horas.</p>
	    		<a href="#" class="btn btn-primary">Ampliar</a>
    		</div>
		</article>

		<article class="card border-primary col-8 col-lg-4 col-xl-3 mx-1 mx-xl-2 mt-3 mb-2">
			<img class="card-img-top" src="imagen/zumba.jpg" alt="Card image cap">
			<div class="card-body">
				<h3 class="card-title">Inscripciones a Zumba</h3>
	    		<p class="card-text text-justify">Quedan abiertas las inscripciones para Zumba Fitness a cargo de la instructora Ángeles Garnier hasta el día Sábado 11 de Agosto.</p>
	    		<a href="#" class="btn btn-primary">Ampliar</a>
    		</div>
		</article>

		<article class="card border-primary col-8 col-lg-4 col-xl-3 mx-1 mx-xl-2 mt-3 mb-2">
			<img class="card-img-top" src="imagen/crossfit.jpg" alt="Card image cap">
			<div class="card-body">
				<h3 class="card-title">Torneo de Crossfit</h3>
	    		<p class="card-text text-justify">El Sábado 18 de Agosto tendrá lugar, en las instalaciones de Energym, el 2º torneo regional de Crossfit. El periodo de inscripción cierra el Miércoles 15.</p>
	    		<a href="#" class="btn btn-primary">Ampliar</a>
    		</div>
		</article>
	
		<article class="card border-primary col-8 col-lg-4 col-xl-3 mx-1 mx-xl-2 my-2">
			<img class="card-img-top" src="imagen/suplementos.png" alt="Card image cap">
			<div class="card-body">
				<h3 class="card-title">Suplementos deportivos</h3>
	    		<p class="card-text text-justify">Expertos en sumplementos deportivos darán una charla informativa gratuita el día Miércoles 8 de Agosto a las 19:00 horas.</p>
	    		<a href="#" class="btn btn-primary">Ampliar</a>
    		</div>
		</article>

		<article class="card border-primary col-8 col-lg-4 col-xl-3 mx-1 mx-xl-2 my-2">
			<img class="card-img-top" src="imagen/zumba.jpg" alt="Card image cap">
			<div class="card-body">
				<h3 class="card-title">Inscripciones a Zumba</h3>
	    		<p class="card-text text-justify">Quedan abiertas las inscripciones para Zumba Fitness turno tarde a cargo de la instructora Ángeles Garnier hasta el día Sábado 11 de Agosto.</p>
	    		<a href="#" class="btn btn-primary">Ampliar</a>
    		</div>
		</article>

		<article class="card border-primary col-8 col-lg-4 col-xl-3 mx-1 mx-xl-2 my-2">
			<img class="card-img-top" src="imagen/crossfit.jpg" alt="Card image cap">
			<div class="card-body">
				<h3 class="card-title">Torneo de Crossfit</h3>
	    		<p class="card-text text-justify">El Sábado 18 de Agosto tendrá lugar, en las instalaciones de Energym, el 2º torneo regional de Crossfit. El periodo de inscripción cierra el Miércoles 15.</p>
	    		<a href="#" class="btn btn-primary">Ampliar</a>
    		</div>
		</article>
	</div>
</section>
<div class=row style="z-index:10000000">
	<div class="offset-7">
  	<ul class="pagination ml-5">
	    <li class="page-item">
	      <a class="page-link" href="#" tabindex="-1">Anterior</a>
	    </li>
	    <li class="page-item active">
	    	<a class="page-link" href="#">1</a>
	    </li>
	    <li class="page-item">
	      <a class="page-link" href="#">2</a>
	    </li>
	    <li class="page-item">
	    	<a class="page-link" href="#">3</a>
	    </li>
	    <li class="page-item">
	      <a class="page-link" href="#">Siguiente</a>
	    </li>
	</ul>
	</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
<style>img[alt="www.000webhost.com"]{display:none}</style>﻿
</html>