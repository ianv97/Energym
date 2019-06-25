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
	<title>Energym - Cobro de cuotas</title>
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

if (isset($_POST["regcobro-boton"])){
	$qry="UPDATE Cuota SET pagada=1 WHERE id_cuota=?";
	$resultado=$conexion->prepare($qry);
	$resultado->execute(array($_POST['cobro_idcuota1']));
	if (isset($_POST["cobrocheck2"])){
		$qry="UPDATE Cuota SET pagada=1 WHERE id_cuota=?";
		$resultado=$conexion->prepare($qry);
		$resultado->execute(array($_POST['cobro_idcuota2']));
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
		<h1 id="regcobro-titulo" style="font-weight:bold;">Cobro de cuotas</h1>
	</div>
	<div class="d-flex justify-content-center">
		<div class="row my-3">
			<div class="input-group input-group-large" id="regcobro-usuariodnic">
				<input type="text" class="form-control inputcentro" name="regcobro-usuariodni" placeholder="Usuario o DNI" id="regcobro-usuariodni">
			</div>
		</div>
	</div>
	<div class="d-flex justify-content-center">
		<div class="row my-2">
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#regcobro-modal" onclick="registrarCobro()">Verificar</button>
		</div>
	</div>
</div>


<div class="modal fade" id="regcobro-modal" tabindex="-1" role="dialog" style="z-index:10000004">
	<div class="modal-dialog" role="document">
		<div class="modal-content" style="margin-top:15vh; margin-left:-6vw;">
			<div class="modal-header">
				<h5 class="modal-title">Cobro de cuotas</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style="background-image: url(https://energym.tk/imagen/fondo_formulario.jpg);">
				<form method="post" action="" enctype="multipart/form-data" id="regcobro-formulario">
					<div class="input-group input-group-large mb-2 d-flex justify-content-center">
						<img src="Uploads/anonimo.jpg" class="recuadro" id="regcobro-foto" name="regcobro-foto"/>
					</div>
					<div class="row d-flex justify-content-center">
						<div class="input-group input-group-large mt-4 mb-2" id="regcobro-usuarioc">
							<input disabled="disabled" id="regcobro-usuario" class="form-control inputcentro" name="regcobro-usuario" placeholder="Usuario" aria-label="Usuario">
						</div>
					</div>
					<div class="row d-flex justify-content-center">
						<div class="input-group input-group-large my-2" id="regcobro-nyac">
							<input disabled="disabled" type="text" id="regcobro-nya" class="form-control inputcentro" name="regcobro-nya" placeholder="Apellido y Nombre" aria-label="Apellido y Nombre">
						</div>
					</div>
					<div class="row d-flex justify-content-center">
						<div class="input-group input-group-large my-2" id="regcobro-dnic">
							<input disabled="disabled" type="text" id="regcobro-dni" class="form-control inputcentro" name="regcobro-dni" placeholder="DNI" aria-label="DNI">
						</div>
					</div>
					<div class="dropdown-divider mb-3 mx-0 px-0"></div>
					<div class="row d-flex justify-content-center">
						<div class="input-group input-group-large my-2 regcobrof1" style="display:none; width:140px;">
							<div class="input-group-prepend">
							    <div class="input-group-text">
							      <input type="checkbox" id="cobrocheck1" name="cobrocheck1" onclick="controlarPrecio1()">
							    </div>
							</div>
							<input id="periodo1" type="text" readonly="true" class="form-control">
						</div>
						<div class="input-group ml-3 my-2 regcobrof1" style="display:none; width:145px; height:38px;">
							<div class="input-group-prepend">
								<span class="input-group-text">$</span>
							</div>
							<input type="number" readonly="true" class="form-control" id="precio1" name="precio1" value="0">
							<div class="input-group-append">
								<span class="input-group-text">.00</span>
							</div>
						</div>
					</div>
					<div class="row d-flex justify-content-center">
						<div class="input-group input-group-large my-2 regcobrof2" style="display:none; width:140px;">
							<div class="input-group-prepend">
							    <div class="input-group-text">
							      <input type="checkbox" id="cobrocheck2" name="cobrocheck2" onclick="controlarPrecio2()">
							    </div>
							</div>
							<input id="periodo2" type="text" readonly="true" class="form-control">
						</div>
						<div class="input-group ml-3 my-2 regcobrof2" style="display:none; width:145px; height:38px;">
							<div class="input-group-prepend">
								<span class="input-group-text">$</span>
							</div>
							<input type="number" readonly="true" class="form-control" id="precio2" name="precio2" value="0">
							<div class="input-group-append">
								<span class="input-group-text">.00</span>
							</div>
						</div>
					</div>
					<div class="row d-flex justify-content-center">
						<div class="input-group my-2" id="regcobrot" style="display:none; width:155px; height:38px;">
							<div class="input-group-prepend">
								<span class="input-group-text">$</span>
							</div>
							<input type="number" readonly="true" class="form-control" id="preciot" name="preciot" value="0">
							<div class="input-group-append">
								<span class="input-group-text">.00</span>
							</div>
						</div>
					</div>
					<div class="row d-flex justify-content-center">
						<h3 id="noadeuda" style="display:none; color:white;">El cliente no adeuda ninguna cuota</h3>
					</div>
					<div class="row d-flex justify-content-center">
						<h3 id="esempleado" style="display:none; color:white;">El usuario ingresado es un empleado</h3>
					</div>
					<input type="hidden" name="cobro_idcuota1" id="cobro_idcuota1">
					<input type="hidden" name="cobro_idcuota2" id="cobro_idcuota2">
				</form>
			</div>
			<div class="modal-footer bg-dark d-flex justify-content-center">
				<button disabled="disabled" type="submit" form="regcobro-formulario" class="btn btn-primary" id="regcobro-boton" name="regcobro-boton" style="font-weight:bold;">Registrar cobro</button>
			</div>
		</div>
	</div>
</div>

</body>

<script type="text/javascript">
function controlarPrecio1(){
	if ($('#cobrocheck1').prop("checked")==false){
		$('#regcobro-boton').prop("disabled","disabled");
		$('#precio1').val(0);
	}else{
		$('#regcobro-boton').removeAttr("disabled");
		$('#precio1').val(datos2[0]['precio']);
	};
	if ($('#cobrocheck1').prop("checked")==true && $('#cobrocheck2').prop("checked")==true){
		$('#preciot').val(parseInt(datos2[0]['precio'])+parseInt(datos2[1]['precio']));
		$('#regcobrot').css("display","");
		$('#regcobrot').css("visibility","visible");
	}else{
		$('#preciot').val(0);
		$('#regcobrot').css("display","none");
	};
};
function controlarPrecio2(){
	if ($('#cobrocheck2').prop("checked")==false){
		$('#precio2').val(0);
	}else{
		$('#precio2').val(datos2[1]['precio']);
	};
	if ($('#cobrocheck1').prop("checked")==true && $('#cobrocheck2').prop("checked")==true){
		$('#preciot').val(parseInt(datos2[0]['precio'])+parseInt(datos2[1]['precio']));
		$('#regcobrot').css("display","");
		$('#regcobrot').css("visibility","visible");
	}else{
		$('#preciot').val(0);
		$('#regcobrot').css("display","none");
	};
}

function registrarCobro(){
	var usuario = $('#regcobro-usuariodni').val();
	$.ajax({
		type:"POST",
		data:"accion=9 & usuario_d=" + usuario,
		url:"bd.php",
		success:function(r){
			datos=jQuery.parseJSON(r);
			if ($.isEmptyObject(datos['foto'])){
				$('#regcobro-foto').attr("src","Uploads/anonimo.jpg");
			}else{
				$('#regcobro-foto').attr("src","Uploads/"+datos['foto']);
			};
			$('#regcobro-usuario').val(datos['usuario']);
			$('#regcobro-nya').val(datos['apellido']+', '+datos['nombre']);
			$('#regcobro-dni').val(datos['dni']);
			if ($.isEmptyObject(datos)){
				$('#regcobro-boton').prop("disabled","disabled");
				$('#esempleado').css("display","none");
				$('#noadeuda').css("display","none");
				$('.regcobrof1').css("display","none");
				$('.regcobrof2').css("display","none");
				$('#regcobrot').css("display","none");
				$('#cobrocheck1').prop("checked",false);
				$('#cobrocheck2').prop("checked",false);
			}else{
				if(datos['nivel_acceso']!=0){
					$('#esempleado').css("display","block");
					$('#esempleado').css("visibility","visible");
					$('#regcobro-boton').prop("disabled","disabled");
					$('#noadeuda').css("display","none");
					$('.regcobrof1').css("display","none");
					$('.regcobrof2').css("display","none");
					$('#regcobrot').css("display","none");
					$('#cobrocheck1').prop("checked",false);
					$('#cobrocheck2').prop("checked",false);
				}else{
					$('#esempleado').css("display","none");
					$.ajax({
						type:"POST",
						data:"accion=10 & usuarioc=" + datos['usuario'],
						url:"bd.php",
						success:function(r){
							datos2=jQuery.parseJSON(r);
							if ($.isEmptyObject(datos2)){
								$('#regcobro-boton').prop("disabled","disabled");
								$('#noadeuda').css("display","block");
								$('#noadeuda').css("visibility","visible");
								$('#esempleado').css("display","none");
								$('.regcobrof1').css("display","none");
								$('.regcobrof2').css("display","none");
								$('#regcobrot').css("display","none");
								$('#cobrocheck1').prop("checked",false);
								$('#cobrocheck2').prop("checked",false);
							}else{
								$('#periodo1').val(datos2[0]['periodo']);
								$('#precio1').val(datos2[0]['precio']);
								$('#regcobro-boton').removeAttr("disabled");
								$('#noadeuda').css("display","none");
								$('.regcobrof1').css("display","");
								$('.regcobrof1').css("visibility","visible");
								$('#cobrocheck1').prop("checked",true);
								$('#cobro_idcuota1').val(datos2[0]['id_cuota']);
								if ($.isEmptyObject(datos2[1])){
									$('#regcobrof2').css("display","none");
									$('#cobrocheck2').prop("checked",false);
								}else{
									$('#periodo2').val(datos2[1]['periodo']);
									$('.regcobrof2').css("display","");
									$('.regcobrof2').css("visibility","visible");
									$('#cobro_idcuota2').val(datos2[1]['id_cuota']);
								};
							};
						}
					});
				};
			};
		}
	});
};
</script>

<style>img[alt="www.000webhost.com"]{display:none}</style>﻿
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</html>