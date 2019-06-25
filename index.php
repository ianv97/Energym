<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<script src='https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyBq5xgKhHn8i4UsFnUCF0ajrPZVfnMlk9s'></script>
<script type='text/javascript'>
	function init_map(){
		var myOptions = {zoom:15,center:new google.maps.LatLng(-27.449774801298204,-58.980379014819334),mapTypeId: google.maps.MapTypeId.ROADMAP};
		map = new google.maps.Map(document.getElementById('mapa'), myOptions);
		marker = new google.maps.Marker({map: map,position: new google.maps.LatLng(-27.445357,-58.9797782)});
		infowindow = new google.maps.InfoWindow({content:'<strong>Energym</strong><br>Av. Sarmiento 750<br>3500 Resistencia<br>'});
		marker2 = new google.maps.Marker({map: map,position: new google.maps.LatLng(-27.4578065,-58.9853741)});
		infowindow2 = new google.maps.InfoWindow({content:'<strong>Energym</strong><br>Av. San Martín 367<br>3500 Resistencia<br>'});
		google.maps.event.addListener(marker, 'click', function(){infowindow.open(map,marker);});
		infowindow.open(map,marker);
		google.maps.event.addListener(marker2, 'click', function(){infowindow2.open(map,marker2);});
		infowindow2.open(map,marker2);
	}
	google.maps.event.addDomListener(window, 'load', init_map);
</script>

<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel='stylesheet' href="css/estilos.css">
	<link rel="shortcut icon" href="imagen/logo.ico"/>
	<script type="text/javascript" src="js/jquery.js"></script>
	<title>Energym - Inicio</title>
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
    				<a class="nav-link my-2" href="index.php"><button type="button" class="btn active btn-primary bg-warning botones1">Inicio</button></a>
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

<section>
	<div id="indicador" class="carousel slide control_carousel col-9 col-xl-10 mx-0 px-0 my-0 py-0" data-ride="carousel">
			<ol class="carousel-indicators">
			<li data-target="#indicador" data-slide-to="0" class="active"></li>
			<li data-target="#indicador" data-slide-to="1"></li>
			<li data-target="#indicador" data-slide-to="2"></li>
			</ol>
  		<div class="carousel-inner">
	    	<div class="carousel-item active">
	      		<div class="carousel-caption d-md-block">
			    	<img class="mr-2 logo-carousel" src="imagen/logo.svg" alt="logo eg"/>
			    	<h5 class="logo-carousel">Energym</h5>
			  	</div>
	      		<img class="d-block w-100" src="imagen/slide1.jpg" alt="Imagen 1">
	    	</div>
		    <div class="carousel-item">
		    	<div class="carousel-caption d-md-block">
			    	<img class="mr-2 logo-carousel" src="imagen/logo.svg" alt="logo eg"/>
			    	<h5 class="logo-carousel">Energym</h5>
			  	</div>
		    	<img class="d-block w-100" src="imagen/slide2.jpg" alt="Imagen 2">
		    </div>
		    <div class="carousel-item">
		    	<div class="carousel-caption d-md-block">
			    	<img class="mr-2 logo-carousel" src="imagen/logo.svg" alt="logo eg"/>
			    	<h5 class="logo-carousel">Energym</h5>
			  	</div>
		    	<img class="d-block w-100" src="imagen/slide3.jpg" alt="Imagen 3">
		    </div>
			</div>
			<a class="carousel-control-prev control_carousel" href="#indicador" role="button" data-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
			<a class="carousel-control-next control_carousel" href="#indicador" role="button" data-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
			</a>
	</div>
</section>

<label class="bg-warning col-9 col-xl-10 my-0 py-0 text-center text-dark" style="height:7vh; font-size:4vh; font-weight:bold; padding:auto;">¿Dónde nos encontramos?</label>
<div class="col-9 col-xl-10 mx-0 px-0 my-0 py-0" id='mapa' style='height:50vh;'></div>

<label class="bg-warning col-9 col-xl-10 my-0 py-0 text-center text-dark" style="height:7vh; font-size:4vh; font-weight:bold; padding:auto;">¿Qué ofrecemos?</label>

<div class="card col-9 col-xl-10 mx-0 px-1 px-lg-3 px-xl-5 my-0 py-0" style="background-color:black; color:white;">
  <div class="card-body">
    <p class="card-text mx-4 mx-xl-5">
		<img src="imagen/iniciocomplemento.jpg" style="width:30vw; float:right; margin:0 5vh;">
    	<h2 class="card-title">Gimnasia de Complemento</h2>
    	<div style="text-align:justify;">
    	La gimnasia de complemento es una actividad física destinada al fortalecimiento y mantenimiento de una buena forma física del cuerpo a través de un conjunto de ejercicios establecidos. Se propone un trabajo físico para mejorar la fuerza, el equilibrio, la coordinación, la elongación y la flexibilidad, trabajando con diferentes pesos y aparatos del gimnasio, mejorando la calidad de vida.
    	</div>
	</p>
  </div>
</div>
<div class="dropdown-divider"></div>
<div class="card col-9 col-xl-10 mx-0 px-1 px-lg-3 px-xl-5 my-0 py-0" style="background-color:black; color:white;">
  <div class="card-body">
    <p class="card-text mx-4 mx-xl-5">
		<img src="imagen/iniciozumba.jpg" style="width:30vw; float:right; margin:0 5vh;">
    	<h2 class="card-title">Zumba</h2>
    	<div style="text-align:justify;">
    	Es una disciplina enfocada por una parte a mantener un cuerpo saludable y por otra a desarrollar, fortalecer y dar flexibilidad al cuerpo mediante movimientos de baile combinados con una serie de rutinas aeróbicas. Zumba utiliza dentro de sus rutinas los principales ritmos latinoamericanos, como lo son la salsa, el merengue, la bachata, la cumbia, reggaetón y el samba. Se trata de una actividad aeróbica para clases dirigidas, utilizando pasos, estilo y música; cada clase consiste en una sucesión de canciones que suman 60 minutos.
    	</div>
	</p>
  </div>
</div>
<div class="dropdown-divider"></div>
<div class="card col-9 col-xl-10 mx-0 px-1 px-lg-3 px-xl-5 my-0 py-0" style="background-color:black; color:white;">
  <div class="card-body">
    <p class="card-text mx-4 mx-xl-5">
		<img src="imagen/iniciocrossfit.jpg" style="float:right; margin:0 5vh; width:30vw;">
    	<h2 class="card-title">Crossfit</h2>
    	<div style="text-align:justify;">
    	Se trata de un sistema de acondicionamiento físico basado en ejercicios constantemente variados, con movimientos funcionales, ejecutados a alta intensidad. CrossFit es una técnica de entrenamiento que encadena movimientos de diferentes disciplinas al mismo tiempo, tales como la halterofilia, el entrenamiento metabólico o el gimnástico. La meta es desarrollar las capacidades y habilidades humanas. Exponiendo a la persona a tantos escenarios y combinaciones de movimientos como sea posible.
    	</div>
	</p>
  </div>
</div>

</body>
<style>img[alt="www.000webhost.com"]{display:none}</style>﻿
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</html>


