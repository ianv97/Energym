<?php
	session_start();
	if (!isset($_SESSION["usuario"])) {header("Location: index.php");}
	if ($_SESSION["nacceso"]!=1) {header("Location: index.php");}
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
	<title>Energym - Clientes</title>
    <style type="text/css">
        body {position:relative; background-image:url(imagen/fondo-perfil.jpg); z-index: 10000000;}
    </style>
</head>

<body>

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

$qry="SELECT usuario,nombre,apellido,dni,fecha_nac,sexo FROM Usuario
where nivel_acceso = 0" ;
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

<div class="card col-9 col-xl-10" id="clientes-card">
    <div class="card-body">
        <h5 class="card-title text-center" id="rutinas-card-titulo">Clientes</h5>
        <div class="table-responsive">
    		<table class="table table-hover text-center" id="clientes-tabla">
    			<thead class="bg-dark" style="color:white; font-weight:bold;">
    				<tr>
                        <td>Apellido y Nombre</td>
                        <td>DNI</td>
                        <td>Fecha de Nacimiento</td>
                        <td>Sexo</td>
                        <td>Ver rutinas</td>
    				</tr>
    			</thead>
    			<tfoot class="bg-primary" style="color:white; font-weight:bold;">
                    <tr>
                        <td>Apellido y Nombre</td>
                        <td>DNI</td>
                        <td>Fecha de Nacimiento</td>
                        <td>Sexo</td>
                        <td>Ver rutinas</td>
                    </tr>
    			</tfoot>
                <tbody>
                <?php 
                while ($row=$resultado->fetch(PDO::FETCH_BOTH)) {
                ?>
                  <tr>
                    <form action="profesores-rutinaxcliente.php" method="post">
                    <input type="hidden" id="rutinausuario" name="rutinausuario" value="<?php echo $row['usuario'] ?>"/>
                    <td><?php echo $row['apellido'].', '.$row['nombre'] ?></td>
                    <td><?php echo $row['dni'] ?></td>
                    <td><?php echo $row['fecha_nac'] ?></td>
                    <td><?php echo $row['sexo'] ?></td>
                    <td>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-dumbbell"></i>
                        </button>
                    </td>
                    </form>
                  </tr>
                <?php };?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>

<script type="text/javascript">
$(document).ready(function() {
    $('#clientes-tabla').DataTable( {
        "order": [[0, "asc"]],
        "language": {
            "emptyTable": "Tabla vacía",
            "lengthMenu": "Mostrar _MENU_ clientes por página",
            "zeroRecords": "No hay coincidencias con el criterio de búsqueda",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ clientes",
            "infoEmpty": "No hay clientes para mostrar",
            "infoFiltered": "(filtrado de un total de _MAX_ clientes)",
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
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>