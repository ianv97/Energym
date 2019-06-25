<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel='stylesheet' href="css/estilos.css">
</head>
<?php
$db_host="localhost";
$db_usuario="id5245865_ianv97";
$db_clave="g7energymg7";
$db_nombre="id5245865_energym";
$conexion=new PDO("mysql:host=$db_host; dbname=$db_nombre","$db_usuario","$db_clave");
$conexion->exec("SET CHARACTER SET utf8");
$usuario=$_SESSION["usuario"];
$qry="SELECT nombre,apellido,foto FROM Usuario WHERE usuario=?";
$resultado=$conexion->prepare($qry);
$resultado->execute(array($usuario));
$row=$resultado->fetch(PDO::FETCH_ASSOC);
if ($row['foto'] != NULL){
	$dir_foto=$row['foto'];
}else{
	$dir_foto='anonimo.jpg';
}
?>

<body>
	<aside class="container-fluid sidebar-sticky text-white position-absolute bg-primary col-3 col-xl-2 px-1 px-sm-1 px-md-2 px-lg-4 px-xl-4 lateral">
		<form method="post" action="logout.php">
			<ul class="nav flex-column">
				<li class="nav-item d-flex justify-content-center">
					<img src="Uploads/<?php echo $dir_foto; ?>" alt="foto-usuario" class="recuadro" id="foto-usuario" name="foto-usuario"/>
				</li>
				<li class="nav-item d-flex justify-content-center">
					<label id="nya-usuario" name="nya-usuario"><?php echo ($row['nombre'].' '.$row['apellido']); ?></label>
				</li>
				<li class="nav-item">
					<a href="perfil.php" style="text-decoration:none;"><button type="button" class="subotones1 btn btn-warning btn-block my-0 my-md-2 my-lg-3 mx-1 mt-1 mb-0 px-0 px-sm-1 px-md-2 px-lg-2 px-xl-3">Perfil</button></a>
				</li>
				<li class="nav-item">
					<a href="empleados.php" style="text-decoration:none;"><button type="button" class="subotones1 btn btn-warning btn-block my-0 my-md-2 my-lg-3 mx-1 mt-1 mb-0 px-0 px-sm-1 px-md-2 px-lg-2 px-xl-3">Empleados</button></a>
				</li>
				<li class="nav-item">
					<a href="asistenciaemp.php" style="text-decoration:none;"><button type="button" class="subotones1 btn btn-warning btn-block my-0 my-md-2 my-lg-3 mx-1 mt-1 mb-0 px-0 px-sm-1 px-md-2 px-lg-2 px-xl-3">Asistencia</button></a>
				</li>
                <li class="nav-item">
					<a href="eventos.php" style="text-decoration:none;"><button type="button" class="subotones1 btn btn-warning btn-block my-0 my-md-2 my-lg-3 mx-1 mt-1 mb-0 px-0 px-sm-1 px-md-2 px-lg-2 px-xl-3">Eventos</button></a>
				</li>
			    <li class="nav-item">
					<button type="submit" class="subotones1 btn btn-block btn-dark text-warning my-0 my-md-2 my-lg-3 mx-1 mt-1 mb-0 px-0 px-sm-1 px-md-2 px-lg-2 px-xl-3" name="cerrar-sesion" id="cerrar-sesion">Cerrar sesión</button>
				</li>
			</ul>
		</form>
	</aside>

	<footer id="copyright">
			&copy; 2018 Energym
	</footer>

</body>

</html>