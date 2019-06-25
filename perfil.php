<?php
	session_start();
  if (!isset($_SESSION["usuario"])) {header("Location:index.php");}
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
	<title>Energym - Perfil</title>
  <style type="text/css">
    body {position:relative; background-image:url(imagen/fondo-perfil.jpg); z-index: 10000000;}
  </style>
</head>
<body>

<script type="text/javascript">
  $(document).on('submit','#perfil-formulario-cambiarcontraseña', function(event){
  event.preventDefault();
    $.ajax({
      type:"POST",
      data:"accion=3 &" + $(this).serialize(),
      url:"bd.php",
      success:function(r){
        alert(r);
        location.reload();
      }
    });
  });
</script>

<?php
if (isset($_SESSION["usuario"])) {
  switch($_SESSION["nacceso"]) {
    case 0: require "sidebar-usuario.php";break;
    case 1: require "sidebar-profesor.php";break;
    case 2: require "sidebar-secretaria.php";break;
    case 3: require "sidebar-administradora.php";break;
    case 4: require "sidebar-gerente.php";break;
  }
}
 
function formatear_fecha ($fecha_nac) {
$pos=stripos($fecha_nac, "/");
$dia=substr($fecha_nac,0,$pos);
$fecha_nac=substr($fecha_nac,$pos+1,strlen($fecha_nac)-$pos+1);
$pos=stripos($fecha_nac, "/");
$mes=substr($fecha_nac,0,$pos);
$año=substr($fecha_nac,$pos+1,strlen($fecha_nac)-$pos+1);
$fecha_nac="$año/$mes/$dia";
return $fecha_nac;
}

$db_host="localhost";
$db_usuario="id5245865_ianv97";
$db_clave="g7energymg7";
$db_nombre="id5245865_energym";
$conexion=new PDO("mysql:host=$db_host; dbname=$db_nombre","$db_usuario","$db_clave");
$conexion->exec("SET CHARACTER SET utf8");
$usuario=$_SESSION["usuario"];
$qry="SELECT * FROM Usuario WHERE usuario=?";
$resultado=$conexion->prepare($qry);
$resultado->execute(array($usuario));
$row=$resultado->fetch(PDO::FETCH_ASSOC);
if ($row['foto'] != NULL){
  $dir_foto=$row['foto'];
}else{
  $dir_foto='anonimo.jpg';
};

if (isset($_POST["perfil-boton-envio"])){
try {
  empty($_POST["perfil-email"])? $email=$row['email'] : $email=$_POST["perfil-email"];
  empty($_POST["perfil-nombre"])? $nombre=$row['nombre'] : $nombre=$_POST["perfil-nombre"];
  empty($_POST["perfil-apellido"])? $apellido=$row['apellido'] : $apellido=$_POST["perfil-apellido"];
  empty($_POST["perfil-fecha-nac"])? $fecha_nac=$row['fecha_nac'] : $fecha_nac=$_POST["perfil-fecha-nac"];
  empty($_POST["perfil-dni"])? $dni=$row['dni'] : $dni=$_POST["perfil-dni"];
  empty($_POST["perfil-celular"])? $celular=$row['celular'] : $celular=$_POST["perfil-celular"];
  empty($_POST["perfil-altura"])? $altura=$row['altura'] : $altura=$_POST["perfil-altura"];
  empty($_POST["perfil-peso"])? $peso=$row['peso'] : $peso=$_POST["perfil-peso"];
  empty($_POST["perfil-talla"])? $talla=$row['talla'] : $talla=$_POST["perfil-talla"];
  
  if ($_FILES['perfil-fotoadj']['error']==0) {
    $tamaño_foto=$_FILES ['perfil-fotoadj']['size'];
    if ($tamaño_foto<=3000000) {
      $tipo_foto=$_FILES ['perfil-fotoadj']['type'];
      if ($tipo_foto=='image/jpg'||$tipo_foto=='image/jpeg'||$tipo_foto=='image/png'||$tipo_foto=='image/gif'){
        $destino=$_SERVER['DOCUMENT_ROOT'] . '/Uploads/';
        $nombre_foto=$_FILES ['perfil-fotoadj']['name'];
        move_uploaded_file($_FILES['perfil-fotoadj']['tmp_name'], $destino.$nombre_foto);
      }else{
        echo "La imagen debe estar en formato jpg, jpeg, png o gif";
        $nombre_foto=$dir_foto;
      }
    }else{
      echo "El tamaño de la imagen excede el límite de 3 MB";
      $nombre_foto=$dir_foto;
    }
  }else{$nombre_foto=$dir_foto;}
  $qry="UPDATE Usuario SET email=:email, nombre=:nombre, apellido=:apellido, fecha_nac=:fecha_nac, foto=:foto, dni=:dni, celular=:celular, altura=:altura, peso=:peso, talla=:talla WHERE usuario=:usuario";
  $resultado=$conexion->prepare($qry);
  $resultado->execute(array(":email"=>$email, ":nombre"=>$nombre, ":apellido"=>$apellido, ":fecha_nac"=>$fecha_nac, ":foto"=>$nombre_foto, ":dni"=>$dni, ":celular"=>$celular, ":altura"=>$altura, ":peso"=>$peso, ":talla"=>$talla, ":usuario"=>$usuario));
  if (($resultado->errorCode())!='00000'){
    echo "¡Error en la consulta a la BD!";
    echo $resultado->errorCode();
  }else{
    if ($_FILES['perfil-fotoadj']['error']!=0){
      echo "<script> alert('¡Perfil actualizado con éxito!')</script>";
      $qry="SELECT * FROM Usuario WHERE usuario=?";
      $resultado=$conexion->prepare($qry);
      $resultado->execute(array($usuario));
      $row=$resultado->fetch(PDO::FETCH_ASSOC);
      if ($row['foto'] != NULL){
        $dir_foto=$row['foto'];
      }else{
        $dir_foto='anonimo.jpg';
      }
      $resultado->closeCursor();
    }
  }

}catch(Exception $e){
  echo "<script> alert('Error al conectar con la Base de datos.')</script>";
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


<section>
  <form method="post" action="" enctype="multipart/form-data">
    <div class="input-group input-group-large mb-2 justify-content-center">
      <img src="Uploads/<?php echo $dir_foto; ?>" alt="foto-usuario" class="recuadro" id="perfil-foto" name="perfil-foto"/>
    </div>
    <div class="d-flex justify-content-center">
      <div class="input-group" id="perfil-contenedor-foto">
        <label for="perfil-fotoadj" style="margin-top: 1vw">Adjuntar foto</label>
        <input type="file" class="form-control-file" id="perfil-fotoadj" name="perfil-fotoadj">
      </div>
    </div>
    <div class="d-flex justify-content-center mt-4">
    	<label style="color:white; margin-right:22vw; font-weight:bold;">Email</label>
    </div>
    <div class="d-flex justify-content-center">
      <div class="input-group input-group-large mb-3" id="perfil-email">
        <input type="email" value="<?php echo $row['email'] ?>" class="form-control text-center" id="perfil-emailf" name="perfil-email" placeholder="E-mail" aria-label="E-mail">
      </div>
    </div>
    <div class="d-flex justify-content-center">
      <button type="button" class="btn btn-warning mt-2 mb-4 d-flex justify-content-center" name="perfil-boton-cambiarcontraseña" id="perfil-boton-cambiarcontraseña" data-toggle="modal" data-target="#perfil-cambiarcontraseña">Cambiar contraseña</button>
    </div>
    <div class="row perfil-fila d-flex justify-content-center mt-3">
    	<label style="color:white; font-weight:bold; width:180px;">Nombre</label>
    	<label class="mx-5" style="color:white; font-weight:bold; width:180px;">Apellido</label>
    </div>
    <div class="row perfil-fila d-flex justify-content-center">
      <div class="input-group input-group-large mb-3" id="perfil-nombre">
        <input type="text" value="<?php echo $row['nombre'] ?>" class="form-control" name="perfil-nombre" placeholder="Nombre" aria-label="Nombre">
      </div>
      <div class="input-group input-group-large mb-3 mx-5" id="perfil-apellido">
        <input type="text" value="<?php echo $row['apellido'] ?>" class="form-control" name="perfil-apellido" placeholder="Apellido" aria-label="Apellido">
      </div>
    </div>
    <div class="row perfil-fila d-flex justify-content-center mt-2">
    	<label style="color:white; font-weight:bold; width:180px;">Fecha de nacimiento</label>
    	<label class="mx-5" style="color:white; font-weight:bold; width:180px;">Altura</label>
    </div>
    <div class="row perfil-fila d-flex justify-content-center">
      <div class="input-group input-group-large mb-3" id="perfil-fecha-nac">
        <input type="date" value="<?php echo $row['fecha_nac'] ?>" class="form-control" name="perfil-fecha-nac" aria-label="Fecha de Nacimiento">
      </div>
      <div class="input-group input-group-large mb-3 mx-5" id="perfil-altura">
        <input type="text" value="<?php echo $row['altura'] ?>" class="form-control" name="perfil-altura" placeholder="Altura" aria-label="Altura">
      </div>
    </div>
    <div class="row perfil-fila d-flex justify-content-center mt-2">
    	<label style="color:white; font-weight:bold; width:180px;">DNI</label>
    	<label class="mx-5" style="color:white; font-weight:bold; width:180px;">Peso</label>
    </div>
    <div class="row perfil-fila d-flex justify-content-center">
      <div class="input-group input-group-large mb-3" id="perfil-dni">
        <input type="text" value="<?php echo $row['dni'] ?>" class="form-control" name="perfil-dni" placeholder="DNI" aria-label="DNI">
      </div>
      <div class="input-group input-group-large mb-3 mx-5" id="perfil-peso">
        <input type="text" value="<?php echo $row['peso'] ?>" class="form-control" name="perfil-peso" placeholder="Peso" aria-label="Peso">
      </div>
    </div>
    <div class="row perfil-fila d-flex justify-content-center mt-2">
    	<label style="color:white; font-weight:bold; width:180px;">Celular</label>
    	<label class="mx-5" style="color:white; font-weight:bold; width:180px;">Talla</label>
    </div>
    <div class="row perfil-fila d-flex justify-content-center">
      <div class="input-group input-group-large mb-3" id="perfil-celular">
        <input type="text" value="<?php echo $row['celular'] ?>" class="form-control" name="perfil-celular" placeholder="Nº Celular" aria-label="N Celular">
      </div>
      <div class="input-group input-group-large mb-3 mx-5" id="perfil-talla">
        <input type="text" value="<?php echo $row['talla'] ?>" class="form-control" name="perfil-talla" placeholder="Talla" aria-label="Talla">
      </div>
    </div>
    <div class="d-flex justify-content-center">
      <button type="submit" class="btn btn-primary btn-lg my-4 d-flex justify-content-center" name="perfil-boton-envio" id="perfil-boton-envio">Actualizar información</button>
    </div>
  </form>
</section>


<!-- Ventana Modal -->
<div class="modal fade" id="perfil-cambiarcontraseña" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="margin-left:-6vw;">
      <div class="modal-header">
        <h5 class="modal-title" id="perfil-titulomodal">Cambiar contraseña</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="background-image: url(https://energym.tk/imagen/fondo_formulario.jpg);">
        <form id="perfil-formulario-cambiarcontraseña">
          <div class="row mt-3 justify-content-center">
            <label id="lncontraseña" style="color:white; font-size:18px">Nueva contraseña: </label>
            <label><input type="password" class="form-control mx-3" id="ncontraseña" name="ncontraseña"></label>
          </div>
          <div class="row mt-3 mb-4 justify-content-center">
            <label id="lrncontraseña" style="color:white; font-size:18px">Repetir contraseña:  </label>
            <label><input type="password" class="form-control mx-3" id="rncontraseña" name="rncontraseña"></label>
          </div>
          <div class="dropdown-divider"></div>
          <div class="row mt-2 justify-content-center">
            <label id="lacontraseña" style="color:white; font-size:18px">Contraseña anterior:</label>
            <label><input type="password" class="form-control mx-3" id="acontraseña" name="acontraseña"></label>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-dark d-flex justify-content-center">
        <button type="submit" form="perfil-formulario-cambiarcontraseña" class="btn btn-primary d-flex" name="perfil-boton-confirmarcontraseña" id="perfil-boton-confirmarcontraseña">Confirmar</button>
      </div>
    </div>
  </div>
</div>

<style>img[alt="www.000webhost.com"]{display:none}</style>﻿
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>