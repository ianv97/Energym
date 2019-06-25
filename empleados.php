<?php
	session_start();
	if (!isset($_SESSION["usuario"])) {header("Location: index.php");}
	if ($_SESSION["nacceso"]!=4) {header("Location: index.php");}
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
    <link rel="stylesheet" href="css/datatable1.css">
    <link rel="stylesheet" href="css/datatable2.css">
    <link rel='stylesheet' href="css/estilos.css">
	<link rel="shortcut icon" href="imagen/logo.ico"/>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/datatable3.js"></script>
	<script type="text/javascript" src="js/datatable4.js"></script>
	<script type="text/javascript" src="js/datatable5.js"></script>
  	<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/all.js" integrity="sha384-xymdQtn1n3lH2wcu0qhcdaOpQwyoarkgLVxC/wZ5q7h9gHtxICrpcaSUfygqZGOe" crossorigin="anonymous"></script>
	<title>Energym - Empleados</title>
</head>
<body style="position:relative; background-image:url(imagen/fondo-perfil.jpg); z-index: 10000000;">



<?php
if (!isset($_SESSION["usuario"])) {
	require "sidebar.php";
}else{
	switch($_SESSION["nacceso"]) {
	    case 0: require "sidebar-usuario.php";break;
	    case 1: require "sidebar-profesor.php";break;
	    case 2: require "sidebar-secretaria.php";break;
	    case 3: require "sidebar-administradora.php";break;
	    case 4: require "sidebar-gerente.php";break;
	};
};

if (isset($_POST["registro-boton-envio"])){
    empty($_POST["registro-usuario"])? $usuario="nulo" : $usuario=$_POST["registro-usuario"];
    empty($_POST["registro-contraseña"])? $contraseña="nulo" : $contraseña=$_POST["registro-contraseña"];
    empty($_POST["registro-confcontraseña"])? $confcontraseña="nulo" : $confcontraseña=$_POST["registro-confcontraseña"];
    empty($_POST["registro-email"])? $email="nulo" : $email=$_POST["registro-email"];
    empty($_POST["registro-nombre"])? $nombre="nulo" : $nombre=$_POST["registro-nombre"];
    empty($_POST["registro-apellido"])? $apellido="nulo" : $apellido=$_POST["registro-apellido"];
    empty($_POST["registro-fecha-nac"])? $fecha_nac="nulo" : $fecha_nac=$_POST["registro-fecha-nac"];
    empty($_POST["registro-dni"])? $dni="nulo" : $dni=$_POST["registro-dni"];
    isset($_POST["registro-sexo"])? $sexo=$_POST["registro-sexo"] : $sexo="nulo";
    ($_FILES['registro-foto']['error'])==0? $estado_foto="adjuntada" : $estado_foto="nulo";
    if (isset($_POST["opc1"])){
    	$niv_acc=1;
    }else{
		if (isset($_POST["opc3"])){
			$niv_acc=3;
		}else{
			if (isset($_POST["opc4"])){
				$niv_acc=4;
			}else{	
		    	if (empty($_POST["sucursal"])){
		    		$niv_acc="nulo";
		    	}else{
					$niv_acc=2;
				};
			};
    	};
    };

    $nombre_foto='';
    if ($usuario!="nulo" && $contraseña!="nulo" && $confcontraseña!="nulo" && $email!="nulo" && $nombre!="nulo" && $apellido!="nulo" && $fecha_nac!="nulo" && $dni!="nulo"&& $sexo!="nulo" && $niv_acc!="nulo"){
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
    				};
    			}else{
    				echo "<script> alert('El tamaño de la imagen excede el límite de 3 MB')</script>";
    			};
    		};
    		$contraseña=password_hash($contraseña,PASSWORD_DEFAULT);
    		if ($niv_acc!=2){
    			$qry="INSERT INTO Usuario (usuario,contraseña,email,nombre,apellido,fecha_nac,sexo,foto,dni,nivel_acceso) VALUES (?,?,?,?,?,?,?,?,?,?)";
    			$resultado=$conexion->prepare($qry);
    			$resultado->execute(array($usuario,$contraseña,$email,$nombre,$apellido,$fecha_nac,$sexo,$nombre_foto,$dni,$niv_acc));
	    	}else{
	    		$qry="INSERT INTO Usuario (usuario,contraseña,email,nombre,apellido,fecha_nac,sexo,foto,dni,nivel_acceso,sucursal) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
	    		$resultado=$conexion->prepare($qry);
    			$resultado->execute(array($usuario,$contraseña,$email,$nombre,$apellido,$fecha_nac,$sexo,$nombre_foto,$dni,$niv_acc,$_POST["sucursal"]));
	    	};
    		if (($resultado->errorCode())!='00000'){
    			echo "<script> alert('¡Error en la consulta a la Base de Datos!')</script>";
    		}else{
    			echo "<script> alert('¡Usuario registrado con éxito!')</script>";
    		};
    	};
    };
};


if (isset($_POST["empleado-boton-guardar"])){
	$usuario=$_POST['empleado-usuario'];
	$qry="SELECT * FROM Usuario WHERE usuario=?";
	$resultado=$conexion->prepare($qry);
	$resultado->execute(array($usuario));
	$row=$resultado->fetch(PDO::FETCH_ASSOC);
	if ($row['foto'] != NULL){
		$dir_foto=$row['foto'];
	}else{
		$dir_foto='anonimo.jpg';
	};
	empty($_POST["empleado-email"])? $email=$row['email'] : $email=$_POST["empleado-email"];
	empty($_POST["empleado-nombre"])? $nombre=$row['nombre'] : $nombre=$_POST["empleado-nombre"];
	empty($_POST["empleado-apellido"])? $apellido=$row['apellido'] : $apellido=$_POST["empleado-apellido"];
	empty($_POST["empleado-fecha-nac"])? $fecha_nac=$row['fecha_nac'] : $fecha_nac=$_POST["empleado-fecha-nac"];
	empty($_POST["empleado-dni"])? $dni=$row['dni'] : $dni=$_POST["empleado-dni"];
	empty($_POST["empleado-celular"])? $celular=$row['celular'] : $celular=$_POST["empleado-celular"];
	empty($_POST["empleado-altura"])? $altura=$row['altura'] : $altura=$_POST["empleado-altura"];
	empty($_POST["empleado-peso"])? $peso=$row['peso'] : $peso=$_POST["empleado-peso"];
	empty($_POST["empleado-talla"])? $talla=$row['talla'] : $talla=$_POST["empleado-talla"];
	$dniv_acc=$_POST["nivelactivo"];

	if ($_FILES['empleado-fotoadj']['error']==0) {
		$tamaño_foto=$_FILES ['empleado-fotoadj']['size'];
		if ($tamaño_foto<=3000000) {
			$tipo_foto=$_FILES ['empleado-fotoadj']['type'];
			if ($tipo_foto=='image/jpg'||$tipo_foto=='image/jpeg'||$tipo_foto=='image/png'||$tipo_foto=='image/gif'){
				$destino=$_SERVER['DOCUMENT_ROOT'] . '/Uploads/';
				$nombre_foto=$_FILES ['empleado-fotoadj']['name'];
				move_uploaded_file($_FILES['empleado-fotoadj']['tmp_name'], $destino.$nombre_foto);
			}else{
				echo "<script> alert('La imagen debe estar en formato jpg, jpeg, png o gif')</script>";
				$nombre_foto=$dir_foto;
			};
		}else{
			echo "<script> alert('El tamaño de la imagen excede el límite de 3 MB')</script>";
			$nombre_foto=$dir_foto;
		};
	}else{$nombre_foto=$dir_foto;};
	$qry="UPDATE Usuario SET email=:email, nombre=:nombre, apellido=:apellido, fecha_nac=:fecha_nac, foto=:foto, dni=:dni, celular=:celular, altura=:altura, peso=:peso, talla=:talla, nivel_acceso=:nivel_acceso WHERE usuario=:usuario";
	$resultado=$conexion->prepare($qry);
	$resultado->execute(array(":email"=>$email, ":nombre"=>$nombre, ":apellido"=>$apellido, ":fecha_nac"=>$fecha_nac, ":foto"=>$nombre_foto, ":dni"=>$dni, ":celular"=>$celular, ":altura"=>$altura, ":peso"=>$peso, ":talla"=>$talla, "nivel_acceso"=>$dniv_acc, ":usuario"=>$usuario));
	if (($resultado->errorCode())!='00000'){
		echo "<script> alert('¡Error en la consulta a la BD!')</script>";
	}else{
		if ($_FILES['empleado-fotoadj']['error']!=0){
			echo "<script> alert('¡Empleado actualizado con éxito!')</script>";
		};
	};
};

$qry="SELECT usuario, nombre, apellido, dni, fecha_nac, sexo FROM Usuario WHERE nivel_acceso!=0" ;
$resultado=$conexion->prepare($qry);
$resultado->execute(array());
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


<div class="card col-9 col-xl-10" style="z-index:10000000">
	<div class="card-body">
		<h3 class="card-title text-center" id="empleados-card-titulo">Empleados</h3>
		<div class="row">
			<button type="button" class="btn btn-primary col-4 col-lg-3 col-xl-2 offset-8 offset-lg-9 offset-xl-10 mb-3" style="font-weight:bold;" data-toggle="modal" data-target="#modalnuevoempleado"><span class="fas fa-plus-square"></span>  Nuevo empleado</button>
		</div>
		<div class="table-responsive">
			<table class="table table-hover text-center" id="empleados-tabla">
				<thead class="bg-dark" style="color:white; font-weight:bold;">
					<tr>
						<td>Apellido y Nombre</td>
						<td>Dni</td>
						<td>Fecha de nacimiento</td>
						<td>Sexo</td>
						<td>Ver detalles</td>
					</tr>
				</thead>
				<tfoot class="bg-primary" style="color:white; font-weight:bold;">
					<tr>
						<td>Apellido y Nombre</td>
						<td>Dni</td>
						<td>Fecha de nacimiento</td>
						<td>Sexo</td>
						<td>Ver detalles</td>
					</tr>
				</tfoot>
				<tbody>
					<?php
					while ($row=$resultado->fetch(PDO::FETCH_BOTH)) {?>
						<tr>
							<td><?php echo $row['apellido'].', '.$row['nombre'] ?></td>
							<td><?php echo $row['dni'] ?></td>
							<td><?php echo $row['fecha_nac'] ?></td>
							<td><?php echo $row['sexo'] ?></td>
							<td>
								<span class="btn btn-warning " class="btn btn-warning" data-toggle="modal" data-target="#modaldetalleempleado" onclick="detalleEmpleado('<?php echo $row['usuario'] ?>')">
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



<div class="modal fade" id="modalnuevoempleado" tabindex="-1" role="dialog" style="z-index:10000004">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" style="margin-left:-6vw;">
			<div class="modal-header">
				<div class="d-flex justify-content-center">
					<h5 class="modal-title">Nuevo empleado</h5>
				</div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style="background-image:url(https://energym.tk/imagen/fondo_formulario.jpg);">
				<div class="row align-middle d-flex justify-content-center">
					<h2 class="text-warning" id="registro-titulo" style="text-decoration:none">Registrar Empleado</h2>
				</div>
				<form method="post" action="" enctype="multipart/form-data" id="registro-formulario">
					<div class="row d-flex justify-content-center mt-3">
						<div class="btn-group btn-group-toggle" data-toggle="buttons">
							<label class="btn btn-dark">
								<input type="radio" name="opc1" id="opc1"> Profesor
							</label>
							<label class="btn btn-dark dropdown-toggle" id="botonsec" data-toggle="dropdown">
								<input type="radio" name="opc2" id="opc2"> Secretaría
							</label>
							<div class="dropdown-menu">
							    <button class="dropdown-item" onclick="defSucursal(1)">Sucursal Sarmiento (1)</button>
							    <button class="dropdown-item" onclick="defSucursal(2)">Sucursal San Martin (2)</button>
							</div>
							<label class="btn btn-dark">
								<input type="radio" name="opc3" id="opc3"> Administración
							</label>
							<label class="btn btn-dark">
								<input type="radio" name="opc4" id="opc4"> Dirección
							</label>
						</div>
					</div>
					<div class="row d-flex justify-content-center">
						<div class="input-group input-group-large my-3" id="registro-usuario">
							<input type="text" class="form-control" name="registro-usuario" placeholder="Usuario" aria-label="Usuario">
						</div>
					</div>
					<div class="row d-flex justify-content-center my-3">
						<div class="input-group input-group-large" id="registro-contraseña">
							<input type="password" class="form-control" name="registro-contraseña" placeholder="Contraseña" aria-label="Contraseña">
						</div>
						<div class="input-group input-group-large ml-3" id="registro-confcontraseña">
							<input type="password" class="form-control" name="registro-confcontraseña" placeholder="Repetir Contraseña" aria-label="Repetir Contraseña">
						</div>
					</div>
					<div class="row d-flex justify-content-center">
						<div class="input-group input-group-large my-4" id="registro-email">
							<input type="email" class="form-control" name="registro-email" placeholder="E-mail" aria-label="E-mail">
						</div>
					</div>
					<div class="row d-flex justify-content-center">
						<div class="input-group input-group-large my-3" id="registro-nombre">
							<input type="text" class="form-control" name="registro-nombre" placeholder="Nombre" aria-label="Nombre">
						</div>
						<div class="input-group input-group-large my-3 ml-3" id="registro-apellido">
							<input type="text" class="form-control" name="registro-apellido" placeholder="Apellido" aria-label="Apellido">
						</div>
					</div>
					<div class="row d-flex justify-content-center">
						<div class="mt-5 mb-2" id="registro-fecha-nac">
							<label id="registro-lfecha-nac">Fecha de nacimiento</label>
							<input type="date" class="form-control" name="registro-fecha-nac" aria-label="Fecha de Naciemiento">
						</div>
					</div>
					<div class="row d-flex justify-content-center">
						<div class="input-group input-group-large my-3" id="registro-dni">
							<input type="text" class="form-control" name="registro-dni" placeholder="DNI" aria-label="DNI">
						</div>
					</div>
					<div class="row d-flex justify-content-center my-3">
						<div class="custom-control custom-radio custom-control-inline" id="registro-sexom">
							<input type="radio" value="M" id="customRadioInline1" name="registro-sexo" class="custom-control-input">
							<label class="custom-control-label" for="customRadioInline1">Hombre</label>
						</div>
						<div class="custom-control custom-radio custom-control-inline" id="registro-sexof">
							<input type="radio" value="F" id="customRadioInline2" name="registro-sexo" class="custom-control-input">
							<label class="custom-control-label" for="customRadioInline2">Mujer</label>
						</div>
					</div>
					<div class="row d-flex justify-content-center my-3">
						<div class="form-group" id="contenedor-foto">
							<label for="registro-foto" style="margin-top: 1vw">Foto de Perfil</label>
							<input type="file" class="form-control-file" id="registro-foto" name="registro-foto">
						</div>
					</div>
					<input type="hidden" form="registro-formulario" name="sucursal" id="sucursal">
					<div class="row d-flex justify-content-center">
						<button type="submit" class="btn btn-primary btn-lg my-3" name="registro-boton-envio" id="registro-boton-envio">Registrar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>



<div class="modal fade" id="modaldetalleempleado" tabindex="-1" role="dialog" style="z-index:10000004;">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" style="margin-left:-6vw;">
			<div class="modal-header">
				<h5 class="modal-title d-flex justify-content-center">Detalle de empleado</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style="background-image: url(https://energym.tk/imagen/fondo_formulario.jpg);">
					<form method="post" action="" enctype="multipart/form-data" id="empleado-formulario">
						<div class="row d-flex justify-content-center my-3">
						<div class="btn-group btn-group-toggle" data-toggle="buttons">
							<label class="btn btn-dark" onclick="evaluar(1)">
								<input type="radio" name="dopc1" id="dopc1"> Profesor
							</label>
							<label class="btn btn-dark dropdown-toggle" id="dbotonsec" onclick="evaluar(2)" data-toggle="dropdown">
								<input type="radio" name="dopc2" id="dopc2"> Secretaría
							</label>
							<div class="dropdown-menu">
							    <button class="dropdown-item" onclick="dSucursal(1)">Sucursal Sarmiento (1)</button>
							    <button class="dropdown-item" onclick="dSucursal(2)">Sucursal San Martin (2)</button>
							</div>
							<label class="btn btn-dark" onclick="evaluar(3)">
								<input type="radio" name="dopc3" id="dopc3"> Administración
							</label>
							<label class="btn btn-dark" onclick="evaluar(4)">
								<input type="radio" name="dopc4" id="dopc4"> Dirección
							</label>
						</div>
						</div>
						<div class="input-group input-group-large mb-2 justify-content-center">
							<img src="Uploads/anonimo.jpg" class="recuadro" id="empleado-foto" name="empleado-foto"/>
						</div>
						<div class="d-flex justify-content-center">
							<div class="input-group" id="empleado-contenedor-foto">
								<label for="empleado-fotoadj" style="margin-top: 1vw">Adjuntar foto</label>
								<input type="file" class="form-control-file" name="empleado-fotoadj">
							</div>
						</div>
						<div class="d-flex justify-content-center">
							<div class="input-group input-group-large mt-5 mb-3" id="empleado-usuario">
								<input id="usuarioU" readonly="true" class="form-control" name="empleado-usuario" placeholder="Usuario" aria-label="Usuario">
							</div>
						</div>
						<div class="d-flex justify-content-center">
							<div class="input-group input-group-large my-3" id="empleado-email">
								<input type="email" id="emailU" class="form-control" name="empleado-email" placeholder="E-mail" aria-label="E-mail">
							</div>
						</div>
						<div class="row empleado-fila d-flex justify-content-center">
							<div class="input-group input-group-large my-3" id="empleado-nombre">
								<input type="text" id="nombreU" class="form-control" name="empleado-nombre" placeholder="Nombre" aria-label="Nombre">
							</div>
							<div class="input-group input-group-large my-3 mx-3" id="empleado-apellido">
								<input type="text" id="apellidoU" class="form-control" name="empleado-apellido" placeholder="Apellido" aria-label="Apellido">
							</div>
						</div>
						<div class="row empleado-fila d-flex justify-content-center">
							<div class="input-group input-group-large my-3" id="empleado-fecha-nac">
								<input type="date" id="fecha_nacU" class="form-control" name="empleado-fecha-nac" aria-label="Fecha de Nacimiento">
							</div>
							<div class="input-group input-group-large my-3 mx-5 mx-sm-3" id="empleado-altura">
								<input type="text" id="alturaU" class="form-control" name="empleado-altura" placeholder="Altura" aria-label="Altura">
							</div>
						</div>
						<div class="row empleado-fila d-flex justify-content-center">
							<div class="input-group input-group-large my-3" id="empleado-dni">
								<input type="text" id="dniU" class="form-control" name="empleado-dni" placeholder="DNI" aria-label="DNI">
							</div>
							<div class="input-group input-group-large my-3 mx-5 mx-sm-3" id="empleado-peso">
								<input type="text" id="pesoU" class="form-control" name="empleado-peso" placeholder="Peso" aria-label="Peso">
							</div>
						</div>
						<div class="row empleado-fila d-flex justify-content-center">
							<div class="input-group input-group-large my-3" id="empleado-celular">
								<input type="text" id="celularU" class="form-control" name="empleado-celular" placeholder="Nº Celular" aria-label="N Celular">
							</div>
							<div class="input-group input-group-large my-3 mx-5 mx-sm-3" id="empleado-talla">
								<input type="text" id="tallaU" class="form-control" name="empleado-talla" placeholder="Talla" aria-label="Talla">
							</div>
						</div>
						<input type="hidden" form="empleado-formulario" name="dsucursal" id="dsucursal">
						<input type="hidden" form="empleado-formulario" name="nivelactivo" id="nivelactivo">
					</form>
			</div>
			<div class="modal-footer bg-dark d-flex justify-content-center">
				<div class="row">
					<button type="button" form="empleado-formulario" class="btn btn-danger mr-5" id="popover-eliminar"><i class="fa fa-times"></i> Eliminar</button>
					<button type="submit" form="empleado-formulario" class="btn btn-success ml-5" id="empleado-boton-guardar" name="empleado-boton-guardar"><i class="fa fa-check"></i> Guardar</button>
				</div>
			</div>
		</div>
	</div>
</div>



<script type="text/javascript">

$(document).ready(function() {
    $('#empleados-tabla').DataTable( {
        "order": [[0, "asc"]],
        "language": {
            "emptyTable": "Tabla vacía",
            "lengthMenu": "Mostrar _MENU_ empleados por página",
            "zeroRecords": "No hay coincidencias con el criterio de búsqueda",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ empleados",
            "infoEmpty": "No hay registros para mostrar",
            "infoFiltered": "(filtrado de un total de _MAX_ empleados)",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Búsqueda:",
            "paginate": {
              "next": "Siguiente",
              "previous": "Anterior"
            }
        }
    } );
} );

$('#botonsec').click(function(){
	$(this).addClass('active').siblings().removeClass('active');
});

$('#dbotonsec').click(function(){
	$(this).addClass('active').siblings().removeClass('active');
});

function evaluar(n){
	$('#nivelactivo').val(n);
}

function defSucursal(num){
	$('#sucursal').val(num);
};

function dSucursal(dnum){
	$('#dsucursal').val(dnum);
	evaluar(2);
};

function detalleEmpleado(usuario){
    $.ajax({
      type:"POST",
      data:"accion=11 & usuarioe=" + usuario,
      url:"bd.php",
      	success:function(r){
	        datos=jQuery.parseJSON(r);
	        if ($.isEmptyObject(datos['foto'])){
	            $('#empleado-foto').attr("src","Uploads/anonimo.jpg");
	        }else{
	            $('#empleado-foto').attr("src","Uploads/"+datos['foto']);
	        };
	        $('#usuarioU').val(datos['usuario']);
	        $('#emailU').val(datos['email']);
	        $('#nombreU').val(datos['nombre']);
	        $('#apellidoU').val(datos['apellido']);
	        $('#fecha_nacU').val(datos['fecha_nac']);
	        $('#dniU').val(datos['dni']);
	        $('#celularU').val(datos['celular']);
	        $('#alturaU').val(datos['altura']);
	        $('#pesoU').val(datos['peso']);
	        $('#tallaU').val(datos['talla']);
	        switch (parseInt(datos['nivel_acceso'])){
	        	case 1: $('#dopc1').click();break;
	        	case 2: $('#dbotonsec').addClass('active').siblings().removeClass('active');$('#dsucursal').val(datos[sucursal]);evaluar(2);break;
	        	case 3: $('#dopc3').click();break;
	        	case 4: $('#dopc4').click();break;
	        };
    	}
	});
}

</script>




<style>img[alt="www.000webhost.com"]{display:none}</style>﻿
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</html>