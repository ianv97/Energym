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

<script type="text/javascript">
    $(document).on('submit','#cliente-formulario-cambiarcontraseña', function(event){
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
if (isset($_POST["registro-boton-envio"])){
  try {
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

    $nombre_foto='';
    if ($usuario!="nulo" && $contraseña!="nulo" && $confcontraseña!="nulo" && $email!="nulo" && $nombre!="nulo" && $apellido!="nulo" && $fecha_nac!="nulo" && $dni!="nulo"&& $sexo!="nulo"){
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
    		$qry="INSERT INTO Usuario (usuario,contraseña,email,nombre,apellido,fecha_nac,sexo,foto,dni) VALUES (?,?,?,?,?,?,?,?,?)";
    		$resultado=$conexion->prepare($qry);
    		$resultado->execute(array($usuario,$contraseña,$email,$nombre,$apellido,$fecha_nac,$sexo,$nombre_foto,$dni));
    		if (($resultado->errorCode())!='00000'){
    			echo "<script> alert('¡Error en la consulta a la Base de Datos!')</script>";
    		}else{
    			echo "<script> alert('¡Usuario registrado con éxito!')</script>";
    		};


    		$qry="INSERT INTO Pack (usuario,precio) VALUES (?,?)";
    		$resultado=$conexion->prepare($qry);
    		$resultado->execute(array($usuario,$_POST['ctotal']));
    		$qry="SELECT MAX(id_pack) FROM Pack";
    		$resultado=$conexion->prepare($qry);
    		$resultado->execute();
    		$id_pack=($resultado->fetch(PDO::FETCH_BOTH))[0];
    		if ($_POST['ccomplemento']!=0){
    			$qry="INSERT INTO PackClase (id_pack,id_clase) VALUES ($id_pack,0)";
    			$resultado=$conexion->prepare($qry);
    			$resultado->execute();
    		};
    		if (!empty($_POST["f1id"]) and $_POST["f1id"]!=0){
    			$qry="INSERT INTO PackClase (id_pack,id_clase) VALUES ($id_pack,?)";
    			$resultado=$conexion->prepare($qry);
    			$resultado->execute(array($_POST['f1id']));
    			if (!empty($_POST["f2id"]) and $_POST["f2id"]!=0){
    				$qry="INSERT INTO PackClase (id_pack,id_clase) VALUES ($id_pack,?)";
    				$resultado=$conexion->prepare($qry);
    				$resultado->execute(array($_POST['f2id']));
    				if (!empty($_POST["f3id"]) and $_POST["f3id"]!=0){
                        $qry="INSERT INTO PackClase (id_pack,id_clase) VALUES ($id_pack,?)";
                        $resultado=$conexion->prepare($qry);
                        $resultado->execute(array($_POST['f3id']));
                        if (!empty($_POST["f4id"]) and $_POST["f4id"]!=0){
                            $qry="INSERT INTO PackClase (id_pack,id_clase) VALUES ($id_pack,?)";
                            $resultado=$conexion->prepare($qry);
                            $resultado->execute(array($_POST['f4id']));
                        };
                    };
                };
            };
            $qry="INSERT INTO Cuota (usuario, periodo, precio) VALUES (?, CURDATE(), ?)";
            $resultado=$conexion->prepare($qry);
            $resultado->execute(array($usuario,$_POST['ctotal']));
        };
    }else{
        echo "<script> alert ('Error: Debe rellenar todos los campos.')</script>";
    };

   }catch(Exception $e){
      echo "<script> alert('Error al conectar con la Base de datos.')</script>";
  };
};

if (isset($_POST["cliente-boton-guardar"])){
try {
$usuario=$_POST['cliente-usuario'];
$qry="SELECT *, DATE_FORMAT(fecha_nac,'%d/%m/%Y') AS fecha_nacf FROM Usuario WHERE usuario=?";
$resultado=$conexion->prepare($qry);
$resultado->execute(array($usuario));
$row=$resultado->fetch(PDO::FETCH_ASSOC);
if ($row['foto'] != NULL){
  $dir_foto=$row['foto'];
}else{
  $dir_foto='anonimo.jpg';
};
  empty($_POST["cliente-email"])? $email=$row['email'] : $email=$_POST["cliente-email"];
  empty($_POST["cliente-nombre"])? $nombre=$row['nombre'] : $nombre=$_POST["cliente-nombre"];
  empty($_POST["cliente-apellido"])? $apellido=$row['apellido'] : $apellido=$_POST["cliente-apellido"];
  empty($_POST["cliente-fecha-nac"])? $fecha_nac=$row['fecha_nac'] : $fecha_nac=$_POST["cliente-fecha-nac"];
  empty($_POST["cliente-dni"])? $dni=$row['dni'] : $dni=$_POST["cliente-dni"];
  empty($_POST["cliente-celular"])? $celular=$row['celular'] : $celular=$_POST["cliente-celular"];
  empty($_POST["cliente-altura"])? $altura=$row['altura'] : $altura=$_POST["cliente-altura"];
  empty($_POST["cliente-peso"])? $peso=$row['peso'] : $peso=$_POST["cliente-peso"];
  empty($_POST["cliente-talla"])? $talla=$row['talla'] : $talla=$_POST["cliente-talla"];
  
  if ($_FILES['cliente-fotoadj']['error']==0) {
    $tamaño_foto=$_FILES ['cliente-fotoadj']['size'];
    if ($tamaño_foto<=3000000) {
      $tipo_foto=$_FILES ['cliente-fotoadj']['type'];
      if ($tipo_foto=='image/jpg'||$tipo_foto=='image/jpeg'||$tipo_foto=='image/png'||$tipo_foto=='image/gif'){
        $destino=$_SERVER['DOCUMENT_ROOT'] . '/Uploads/';
        $nombre_foto=$_FILES ['cliente-fotoadj']['name'];
        move_uploaded_file($_FILES['cliente-fotoadj']['tmp_name'], $destino.$nombre_foto);
      }else{
        echo "<script> alert('La imagen debe estar en formato jpg, jpeg, png o gif')</script>";
        $nombre_foto=$dir_foto;
      };
    }else{
      echo "<script> alert('El tamaño de la imagen excede el límite de 3 MB')</script>";
      $nombre_foto=$dir_foto;
    };
  }else{$nombre_foto=$dir_foto;};
    $qry="UPDATE Usuario SET email=:email, nombre=:nombre, apellido=:apellido, fecha_nac=:fecha_nac, foto=:foto, dni=:dni, celular=:celular, altura=:altura, peso=:peso, talla=:talla WHERE usuario=:usuario";
    $resultado=$conexion->prepare($qry);
    $resultado->execute(array(":email"=>$email, ":nombre"=>$nombre, ":apellido"=>$apellido, ":fecha_nac"=>$fecha_nac, ":foto"=>$nombre_foto, ":dni"=>$dni, ":celular"=>$celular, ":altura"=>$altura, ":peso"=>$peso, ":talla"=>$talla, ":usuario"=>$usuario));
  if (($resultado->errorCode())!='00000'){
    echo "<script> alert('¡Error en la consulta a la BD!')</script>";
  }else{
    if ($_FILES['cliente-fotoadj']['error']!=0){
      echo "<script> alert('¡Cliente actualizado con éxito!')</script>";
      if ($row['foto'] != NULL){
        $dir_foto=$row['foto'];
      }else{
        $dir_foto='anonimo.jpg';
      };
    };
  };

}catch(Exception $e){
  echo "<script> alert('Error al conectar con la Base de datos.')</script>";
};

$qry="SELECT id_pack FROM Pack WHERE usuario=?";
$resultado=$conexion->prepare($qry);
$resultado->execute(array($usuario));
$row=$resultado->fetch(PDO::FETCH_BOTH);
$idpack=$row[0];

$qry="UPDATE Pack SET precio=? WHERE id_pack=?";
$resultado=$conexion->prepare($qry);
$resultado->execute(array($_POST['dctotal'],$idpack));

$qry="DELETE FROM PackClase WHERE id_pack=$idpack";
$resultado=$conexion->prepare($qry);
$resultado->execute(array($usuario));

if ($_POST['dccomplemento']!=0){
	$qry="INSERT INTO PackClase (id_pack,id_clase) VALUES ($idpack,0)";
	$resultado=$conexion->prepare($qry);
	$resultado->execute();
};
if (!empty($_POST["df1id"]) and $_POST["df1id"]!=0){
	$qry="INSERT INTO PackClase (id_pack,id_clase) VALUES ($idpack,?)";
	$resultado=$conexion->prepare($qry);
	$resultado->execute(array($_POST['df1id']));
	if (!empty($_POST["df2id"]) and $_POST["df2id"]!=0){
		$qry="INSERT INTO PackClase (id_pack,id_clase) VALUES ($idpack,?)";
		$resultado=$conexion->prepare($qry);
		$resultado->execute(array($_POST['df2id']));
		if (!empty($_POST["df3id"]) and $_POST["df3id"]!=0){
	    	$qry="INSERT INTO PackClase (id_pack,id_clase) VALUES ($idpack,?)";
	      	$resultado=$conexion->prepare($qry);
	      	$resultado->execute(array($_POST['df3id']));
	      	if (!empty($_POST["df4id"]) and $_POST["df4id"]!=0){
		      	$qry="INSERT INTO PackClase (id_pack,id_clase) VALUES ($idpack,?)";
		      	$resultado=$conexion->prepare($qry);
		      	$resultado->execute(array($_POST['df4id']));
		    };
	    };
	};
};



};

if (isset($_POST["cliente-boton-eliminar"])){
	$usuario=$_POST['cliente-usuario'];
	$qry="DELETE FROM Usuario WHERE usuario=?";
	$resultado=$conexion->prepare($qry);
	$resultado->execute(array($usuario));
};

$qry="SELECT precio FROM Clases WHERE id_clase=0";
$resultado=$conexion->prepare($qry);
$resultado->execute();
$row=$resultado->fetch(PDO::FETCH_ASSOC);
$ccomplemento=$row["precio"];

$qry="SELECT nombre,precio,horario,id_clase FROM Clases WHERE id_clase!=0 ORDER BY nombre";
$resultado=$conexion->prepare($qry);
$resultado->execute();
$i=-1;
$auxn="";
while ($row=$resultado->fetch(PDO::FETCH_BOTH)){
	if ($auxn==$row[0]){
		$clases[$i][$j]=$row[2];
		$j+=1;
	}else{
		$i+=1;
		$auxn=$row[0];
		$clases[$i][-1]=$row[3];
		$clases[$i][0]=$row[0];
		$clases[$i][1]=$row[1];
		$clases[$i][2]=$row[2];
		$j=3;
	};
};
$clases[-1][-1]=0;
$clases[-1][0]="-Nombre-";
$clases[-1][1]=0;
$clases[-1][2]="-Horario-";


$qry="SELECT usuario,nombre,apellido,dni,email,fecha_nac,sexo FROM Usuario
where nivel_acceso = 0";
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

<!-- {Tabla de clientes} -->
<div class="card col-9 col-xl-10" id="clientes-card" style="z-index:10000000">
    <div class="card-body">
        <div class="row">
            <button type="button" class="btn btn-primary col-4 col-lg-3 col-xl-2 offset-8 offset-lg-9 offset-xl-10 mb-3" data-toggle="modal" data-target="#modalnuevocliente" style="font-weight:bold;"><span class="fas fa-plus-square"></span>  Nuevo cliente</button>
        </div>
        <div class="table-responsive">
    		<table class="table table-hover text-center" id="clientes-tabla">
    			<thead class="bg-dark" style="color:white; font-weight:bold;">
    				<tr>
                        <td>Apellido y Nombre</td>
                        <td>DNI</td>
                        <td>Fecha de Nacimiento</td>
                        <td>Sexo</td>
                        <td>Ver detalles</td>
    				</tr>
    			</thead>
    			<tfoot class="bg-primary" style="color:white; font-weight:bold;">
                    <tr>
                        <td>Apellido y Nombre</td>
                        <td>DNI</td>
                        <td>Fecha de Nacimiento</td>
                        <td>Sexo</td>
                        <td>Ver detalles</td>
                    </tr>
    			</tfoot>
                <tbody>
                <?php 
                while ($row=$resultado->fetch(PDO::FETCH_BOTH)) {
                ?>
                  <tr>
                    <td><?php echo $row['apellido'].', '.$row['nombre'] ?></td>
                    <td><?php echo $row['dni'] ?></td>
                    <td><?php echo $row['fecha_nac'] ?></td>
                    <td><?php echo $row['sexo'] ?></td>
                    <td>
                        <span class="btn btn-warning" data-toggle="modal" data-target="#modaldetallecliente" onclick="agregarFrmActualizar('<?php echo $row['usuario'] ?>')">
                            <i class="fas fa-eye fa-lg"></i>
                        </span>
                    </td>
                  </tr>
                <?php }?>
                </tbody>
    		</table>
        </div>
    </div>
</div>


<!-- Modal detalle de cliente -->
<div class="modal multi-step fade" id="modaldetallecliente" tabindex="-1" role="dialog" style="z-index:10000004;">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" style="margin-left:-6vw;">
			<div class="modal-header">
				<h5 class="modal-title d-flex justify-content-center">Detalle de cliente</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body step-1" data-step="1" style="background-image: url(https://energym.tk/imagen/fondo_formulario.jpg);">
				<section>
					<button type="button" class="btn btn-primary step-1 mr-2" data-step="1" onclick="sendEvent('modaldetallecliente',2)" style="height:40px; position:absolute; right:0px; z-index:10000005;"><span class="fas fa-angle-double-right"></span></button>
					<form method="post" action="" enctype="multipart/form-data" id="cliente-formulario">
						<div class="input-group input-group-large mb-2 justify-content-center">
							<img src="Uploads/anonimo.jpg" class="recuadro" id="cliente-foto" name="cliente-foto"/>
						</div>
						<div class="d-flex justify-content-center">
							<div class="input-group" id="cliente-contenedor-foto">
								<label for="cliente-fotoadj" style="margin-top: 1vw">Adjuntar foto</label>
								<input type="file" class="form-control-file" name="cliente-fotoadj">
							</div>
						</div>
						<div class="d-flex justify-content-center">
							<div class="input-group input-group-large mt-5 mb-3" id="cliente-usuario">
								<input id="usuarioU" readonly="true" class="form-control" name="cliente-usuario" placeholder="Usuario" aria-label="Usuario">
							</div>
						</div>
						<div class="d-flex justify-content-center">
							<div class="input-group input-group-large my-3" id="cliente-email">
								<input type="email" id="emailU" class="form-control" name="cliente-email" placeholder="E-mail" aria-label="E-mail">
							</div>
						</div>
						<div class="row cliente-fila d-flex justify-content-center">
							<div class="input-group input-group-large my-3" id="cliente-nombre">
								<input type="text" id="nombreU" class="form-control" name="cliente-nombre" placeholder="Nombre" aria-label="Nombre">
							</div>
							<div class="input-group input-group-large my-3 mx-3" id="cliente-apellido">
								<input type="text" id="apellidoU" class="form-control" name="cliente-apellido" placeholder="Apellido" aria-label="Apellido">
							</div>
						</div>
						<div class="row cliente-fila d-flex justify-content-center">
							<div class="input-group input-group-large my-3" id="cliente-fecha-nac">
								<input type="date" id="fecha_nacU" class="form-control" name="cliente-fecha-nac" aria-label="Fecha de Nacimiento">
							</div>
							<div class="input-group input-group-large my-3 mx-5 mx-sm-3" id="cliente-altura">
								<input type="text" id="alturaU" class="form-control" name="cliente-altura" placeholder="Altura" aria-label="Altura">
							</div>
						</div>
						<div class="row cliente-fila d-flex justify-content-center">
							<div class="input-group input-group-large my-3" id="cliente-dni">
								<input type="text" id="dniU" class="form-control" name="cliente-dni" placeholder="DNI" aria-label="DNI">
							</div>
							<div class="input-group input-group-large my-3 mx-5 mx-sm-3" id="cliente-peso">
								<input type="text" id="pesoU" class="form-control" name="cliente-peso" placeholder="Peso" aria-label="Peso">
							</div>
						</div>
						<div class="row cliente-fila d-flex justify-content-center">
							<div class="input-group input-group-large my-3" id="cliente-celular">
								<input type="text" id="celularU" class="form-control" name="cliente-celular" placeholder="Nº Celular" aria-label="N Celular">
							</div>
							<div class="input-group input-group-large my-3 mx-5 mx-sm-3" id="cliente-talla">
								<input type="text" id="tallaU" class="form-control" name="cliente-talla" placeholder="Talla" aria-label="Talla">
							</div>
						</div>
					</form>
				</section>
			</div>
			<div class="modal-body step-2" data-step="2" style="background-image:url(https://energym.tk/imagen/fondo_formulario.jpg);">
            	<section>
            		<button type="button" class="btn btn-primary step-2 ml-2" data-step="2" onclick="sendEvent('modaldetallecliente',1)" style="height:40px; position:absolute; left:0px;"><span class="fas fa-angle-double-left"></span></button>
                    <form method="post" action="" enctype="multipart/form-data">
                    	<div class="row d-flex justify-content-center">
                    		<label class="mr-4" id="dcomplementol" style="color:white; font-size:30px; font-weight:bold; margin-top:-8px;">Complemento</label>
                    		<label class="switch" onclick="dccomplemento()">
								<input form="cliente-formulario" type="checkbox" id="dcheckcomplemento" name="dcheckcomplemento">
								<span class="slider round" onclick="dccomplemento()"></span>
							</label>
							<div class="input-group ml-5" style="width:150px; height:40px;">
								<div class="input-group-prepend">
							    	<span class="input-group-text">$</span>
							  	</div>
							  	<input form="cliente-formulario" type="number" readonly="true" class="form-control" id="dccomplemento" name="dccomplemento" value="0">
							  	<div class="input-group-append">
							    	<span class="input-group-text">.00</span>
							  	</div>
							</div>
						</div>
						<div class="row d-flex justify-content-center mt-5 mb-4">
							<button type="button" class="btn btn-danger mr-3" onclick="dquitar_disciplina()" style="height:40px;"><span class="fas fa-minus-square"></span></button>
							<label id="ddisciplinal" style="color:white; font-size:30px; font-weight:bold;">Disciplinas</label>
							<button type="button" class="btn btn-success ml-3" onclick="dnueva_disciplina()" style="height:40px;"><span class="fas fa-plus-square"></span></button>
						</div>
						<div id="dfila1" class="row d-flex justify-content-center my-2" style="visibility:hidden;">
							<input form="cliente-formulario" type="text" hidden="hidden" id="df1id" name="df1id" value="0">
                    		<div class="form-group mx-3" style="width:140px;">
								<select class="form-control" id="dn1" onchange="dsel_nombre(1)">
								    <option value="-1">-Nombre-</option>
								    <?php $n=0;
								    while ($clases[$n]){
								    	echo "<option value=";echo $n;echo ">";
								    	echo $clases[$n][0];
								    	echo "</option>";
								    	$n+=1;
								    };?>
							  	</select>
							</div>
							<div class="form-group mx-3" style="width:340px;">
								<select class="form-control" id="dh1">
								    <option value="-1">-Horario-</option>
							  	</select>
							</div>
							<div class="input-group ml-3" style="width:150px; height:40px;">
								<div class="input-group-prepend">
							    	<span class="input-group-text">$</span>
							  	</div>
							  	<input type="number" readonly="true" class="form-control" id="dc1" name="dc1" value="0">
							  	<div class="input-group-append">
							    	<span class="input-group-text">.00</span>
							  	</div>
							</div>
						</div>
						<div id="dfila2" class="row d-flex justify-content-center my-2" style="visibility:hidden;">
							<input form="cliente-formulario" type="text" hidden="hidden" id="df2id" name="df2id" value="0">
                    		<div class="form-group mx-3" style="width:140px;">
								<select class="form-control" id="dn2" onchange="dsel_nombre(2)">
								    <option value="-1">-Nombre-</option>
								    <?php $n=0;
								    while ($clases[$n]){
								    	echo "<option value=";echo $n;echo ">";
								    	echo $clases[$n][0];
								    	echo "</option>";
								    	$n+=1;
								    };?>
							  	</select>
							</div>
							<div class="form-group mx-3" style="width:340px;">
								<select class="form-control" id="dh2">
								    <option value="-1">-Horario-</option>
							  	</select>
							</div>
							<div class="input-group ml-3" style="width:150px; height:40px;">
								<div class="input-group-prepend">
							    	<span class="input-group-text">$</span>
							  	</div>
							  	<input type="number" readonly="true" class="form-control" id="dc2" name="dc2" value="0">
							  	<div class="input-group-append">
							    	<span class="input-group-text">.00</span>
							  	</div>
							</div>
						</div>
						<div id="dfila3" class="row d-flex justify-content-center my-2" style="visibility:hidden;">
							<input form="cliente-formulario" type="text" hidden="hidden" id="df3id" name="df3id" value="0">
                    		<div class="form-group mx-3" style="width:140px;">
								<select class="form-control" id="dn3" onchange="dsel_nombre(3)">
								    <option value="-1">-Nombre-</option>
								    <?php $n=0;
								    while ($clases[$n]){
								    	echo "<option value=";echo $n;echo ">";
								    	echo $clases[$n][0];
								    	echo "</option>";
								    	$n+=1;
								    };?>
							  	</select>
							</div>
							<div class="form-group mx-3" style="width:340px;">
								<select class="form-control" id="dh3">
								    <option value="-1">-Horario-</option>
							  	</select>
							</div>
							<div class="input-group ml-3" style="width:150px; height:40px;">
								<div class="input-group-prepend">
							    	<span class="input-group-text">$</span>
							  	</div>
							  	<input type="number" readonly="true" class="form-control" id="dc3" name="dc3" value="0">
							  	<div class="input-group-append">
							    	<span class="input-group-text">.00</span>
							  	</div>
							</div>
						</div>
						<div id="dfila4" class="row d-flex justify-content-center my-2" style="visibility:hidden;">
							<input form="cliente-formulario" type="text" hidden="hidden" id="df4id" name="df4id" value="0">
                    		<div class="form-group mx-3" style="width:140px;">
								<select class="form-control" id="dn4" onchange="dsel_nombre(4)">
								    <option value="-1">-Nombre-</option>
								    <?php $n=0;
								    while ($clases[$n]){
								    	echo "<option value=";echo $n;echo ">";
								    	echo $clases[$n][0];
								    	echo "</option>";
								    	$n+=1;
								    };?>
							  	</select>
							</div>
							<div class="form-group mx-3" style="width:340px;">
								<select class="form-control" id="dh4">
								    <option value="-1">-Horario-</option>
							  	</select>
							</div>
							<div class="input-group ml-3" style="width:150px; height:40px;">
								<div class="input-group-prepend">
							    	<span class="input-group-text">$</span>
							  	</div>
							  	<input type="number" readonly="true" class="form-control" id="dc4" name="dc4" value="0">
							  	<div class="input-group-append">
							    	<span class="input-group-text">.00</span>
							  	</div>
							</div>
						</div>
						<div class="row d-flex justify-content-center mt-4">
							<label style="color:white; font-size:30px; font-weight:bold;">Total</label>
						</div>
						<div class="row d-flex justify-content-center">
							<div class="input-group" style="width:160px; height:40px;">
								<div class="input-group-prepend">
							    	<span class="input-group-text">$</span>
							  	</div>
							  	<input form="cliente-formulario" type="number" readonly="true" class="form-control" id="dctotal" name="dctotal" value="0">
							  	<div class="input-group-append">
							    	<span class="input-group-text">.00</span>
							  	</div>
							</div>
						</div>
					</form>
				</section>
            </div>
			<div class="modal-footer bg-dark d-flex justify-content-center">
				<div class="row">
					<button type="button" form="cliente-formulario" class="btn btn-danger mr-5" id="popover-eliminar"><i class="fa fa-times"></i> Eliminar</button>
					<button type="submit" form="cliente-formulario" class="btn btn-success ml-5" id="cliente-boton-guardar" name="cliente-boton-guardar"><i class="fa fa-check"></i> Guardar</button>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal nuevo cliente -->
<div class="modal multi-step fade" id="modalnuevocliente" tabindex="-1" role="dialog" style="z-index:10000004">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="margin-left:-6vw;">
            <div class="modal-header">
            	<div class="d-flex justify-content-center">
                	<h5 class="modal-title">Nuevo cliente</h5>
            	</div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body step-1" data-step="1" style="background-image:url(https://energym.tk/imagen/fondo_formulario.jpg);">
            		<div class="align-middle d-flex justify-content-center">
            			<button type="button" class="btn btn-primary step-1 mr-2" data-step="1" onclick="sendEvent('modalnuevocliente',2)" style="height:40px; position:absolute; right:0px;"><span class="fas fa-angle-double-right"></span></button>
                    	<h2 class="text-warning" id="registro-titulo" style="margin-bottom:10vh; text-decoration:none">Registrar Cliente</h2>
                	</div>
                    <form method="post" action="" enctype="multipart/form-data">
                    	<div class="row d-flex justify-content-center">
                    		<label class="mr-4" id="complementol" style="color:white; font-size:30px; font-weight:bold; margin-top:-8px;">Complemento</label>
                    		<label class="switch" onclick="ccomplemento()">
								<input form="registro-formulario" type="checkbox" id="checkcomplemento" name="checkcomplemento">
								<span class="slider round" onclick="ccomplemento()"></span>
							</label>
							<div class="input-group ml-5" style="width:150px; height:40px;">
								<div class="input-group-prepend">
							    	<span class="input-group-text">$</span>
							  	</div>
							  	<input form="registro-formulario" type="number" readonly="true" class="form-control" id="ccomplemento" name="ccomplemento" value="0">
							  	<div class="input-group-append">
							    	<span class="input-group-text">.00</span>
							  	</div>
							</div>
						</div>
						<div class="row d-flex justify-content-center mt-5 mb-4">
							<button type="button" class="btn btn-danger mr-3" onclick="quitar_disciplina()" style="height:40px;"><span class="fas fa-minus-square"></span></button>
							<label id="disciplinal" style="color:white; font-size:30px; font-weight:bold;">Disciplinas</label>
							<button type="button" class="btn btn-success ml-3" onclick="nueva_disciplina()" style="height:40px;"><span class="fas fa-plus-square"></span></button>
						</div>
						<div id="fila1" class="row d-flex justify-content-center my-2" style="visibility:hidden;">
							<input form="registro-formulario" type="text" hidden="hidden" id="f1id" name="f1id" value="0">
                    		<div class="form-group mx-3" style="width:140px;">
								<select class="form-control" id="n1" onchange="sel_nombre(1)">
								    <option value="-1">-Nombre-</option>
								    <?php $n=0;
								    while ($clases[$n]){
								    	echo "<option value=";echo $n;echo ">";
								    	echo $clases[$n][0];
								    	echo "</option>";
								    	$n+=1;
								    };?>
							  	</select>
							</div>
							<div class="form-group mx-3" style="width:340px;">
								<select class="form-control" id="h1">
								    <option value="-1">-Horario-</option>
							  	</select>
							</div>
							<div class="input-group ml-3" style="width:150px; height:40px;">
								<div class="input-group-prepend">
							    	<span class="input-group-text">$</span>
							  	</div>
							  	<input type="number" readonly="true" class="form-control" id="c1" name="c1" value="0">
							  	<div class="input-group-append">
							    	<span class="input-group-text">.00</span>
							  	</div>
							</div>
						</div>
						<div id="fila2" class="row d-flex justify-content-center my-2" style="visibility:hidden;">
							<input form="registro-formulario" type="text" hidden="hidden" id="f2id" name="f2id" value="0">
                    		<div class="form-group mx-3" style="width:140px;">
								<select class="form-control" id="n2" onchange="sel_nombre(2)">
								    <option value="-1">-Nombre-</option>
								    <?php $n=0;
								    while ($clases[$n]){
								    	echo "<option value=";echo $n;echo ">";
								    	echo $clases[$n][0];
								    	echo "</option>";
								    	$n+=1;
								    };?>
							  	</select>
							</div>
							<div class="form-group mx-3" style="width:340px;">
								<select class="form-control" id="h2">
								    <option value="-1">-Horario-</option>
							  	</select>
							</div>
							<div class="input-group ml-3" style="width:150px; height:40px;">
								<div class="input-group-prepend">
							    	<span class="input-group-text">$</span>
							  	</div>
							  	<input type="number" readonly="true" class="form-control" id="c2" name="c2" value="0">
							  	<div class="input-group-append">
							    	<span class="input-group-text">.00</span>
							  	</div>
							</div>
						</div>
						<div id="fila3" class="row d-flex justify-content-center my-2" style="visibility:hidden;">
							<input form="registro-formulario" type="text" hidden="hidden" id="f3id" name="f3id" value="0">
                    		<div class="form-group mx-3" style="width:140px;">
								<select class="form-control" id="n3" onchange="sel_nombre(3)">
								    <option value="-1">-Nombre-</option>
								    <?php $n=0;
								    while ($clases[$n]){
								    	echo "<option value=";echo $n;echo ">";
								    	echo $clases[$n][0];
								    	echo "</option>";
								    	$n+=1;
								    };?>
							  	</select>
							</div>
							<div class="form-group mx-3" style="width:340px;">
								<select class="form-control" id="h3">
								    <option value="-1">-Horario-</option>
							  	</select>
							</div>
							<div class="input-group ml-3" style="width:150px; height:40px;">
								<div class="input-group-prepend">
							    	<span class="input-group-text">$</span>
							  	</div>
							  	<input type="number" readonly="true" class="form-control" id="c3" name="c3" value="0">
							  	<div class="input-group-append">
							    	<span class="input-group-text">.00</span>
							  	</div>
							</div>
						</div>
						<div id="fila4" class="row d-flex justify-content-center my-2" style="visibility:hidden;">
							<input form="registro-formulario" type="text" hidden="hidden" id="f4id" name="f4id" value="0">
                    		<div class="form-group mx-3" style="width:140px;">
								<select class="form-control" id="n4" onchange="sel_nombre(4)">
								    <option value="-1">-Nombre-</option>
								    <?php $n=0;
								    while ($clases[$n]){
								    	echo "<option value=";echo $n;echo ">";
								    	echo $clases[$n][0];
								    	echo "</option>";
								    	$n+=1;
								    };?>
							  	</select>
							</div>
							<div class="form-group mx-3" style="width:340px;">
								<select class="form-control" id="h4">
								    <option value="-1">-Horario-</option>
							  	</select>
							</div>
							<div class="input-group ml-3" style="width:150px; height:40px;">
								<div class="input-group-prepend">
							    	<span class="input-group-text">$</span>
							  	</div>
							  	<input type="number" readonly="true" class="form-control" id="c4" name="c4" value="0">
							  	<div class="input-group-append">
							    	<span class="input-group-text">.00</span>
							  	</div>
							</div>
						</div>
						<div class="row d-flex justify-content-center mt-4">
							<label style="color:white; font-size:30px; font-weight:bold;">Total</label>
						</div>
						<div class="row d-flex justify-content-center">
							<div class="input-group" style="width:160px; height:40px;">
								<div class="input-group-prepend">
							    	<span class="input-group-text">$</span>
							  	</div>
							  	<input form="registro-formulario" type="number" readonly="true" class="form-control" id="ctotal" name="ctotal" value="0">
							  	<div class="input-group-append">
							    	<span class="input-group-text">.00</span>
							  	</div>
							</div>
						</div>
						<div class="row d-flex justify-content-center mt-5 mb-4">
                    		<button type="button" class="btn btn-primary step-1" data-step="1" onclick="sendEvent('modalnuevocliente',2)" style="font-weight:bold;">Continuar</button>
                    	</div>
					</form>
            </div>
            <div class="modal-body step-2" data-step="2" style="background-image:url(https://energym.tk/imagen/fondo_formulario.jpg);">
                <section>
                	<div class="row align-middle d-flex justify-content-center">
            			<button type="button" class="btn btn-primary step-2 ml-2" data-step="2" onclick="sendEvent('modalnuevocliente',1)" style="height:40px; position:absolute; left:0px;"><span class="fas fa-angle-double-left"></span></button>
                    	<h2 class="text-warning" id="registro-titulo" style="text-decoration:none">Registrar Cliente</h2>
                    </div>
                    <form method="post" action="" enctype="multipart/form-data" id="registro-formulario">
                    <div class="row d-flex justify-content-center">
                    <div class="input-group input-group-large mt-4 mb-3" id="registro-usuario">
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
                    <div class="row d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary btn-lg my-3" name="registro-boton-envio" id="registro-boton-envio">Registrar</button>
                    </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</div>

</body>

<script type="text/javascript">
$(document).ready(function() {
    $('#clientes-tabla').DataTable( {
        "order": [[1, "asc"]],
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

<script type="text/javascript">
	var complemento=0;
	var clase1=0;
	var clase2=0;
	var clase3=0;
	var clase4=0;

  var cont_dis=0;
  function nueva_disciplina(){
  	switch (cont_dis){
  		case 0: $('#fila1').css("visibility","visible"); cont_dis+=1;;break;
  		case 1: $('#fila2').css("visibility","visible"); cont_dis+=1; break;
  		case 2: $('#fila3').css("visibility","visible"); cont_dis+=1; break;
  		case 3: $('#fila4').css("visibility","visible"); cont_dis+=1; break;
  	};
  };

  function quitar_disciplina(){
  	switch (cont_dis){
  		case 4: $('#fila4').css("visibility","hidden"); $('#h4').empty(); $('#h4').append($('<option>',{value:-1,text:'-Horario-'})); $('#n4').val("-1"); $('#h4').val("-1"); $('#c4').val(0); cont_dis-=1; $('#f1id').val(0); clase4=0; break;
  		case 3: $('#fila3').css("visibility","hidden"); $('#h3').empty(); $('#h3').append($('<option>',{value:-1,text:'-Horario-'})); $('#n3').val("-1"); $('#h3').val("-1"); $('#c3').val(0); cont_dis-=1; $('#f2id').val(0); clase3=0; break;
  		case 2: $('#fila2').css("visibility","hidden"); $('#h2').empty(); $('#h2').append($('<option>',{value:-1,text:'-Horario-'})); $('#n2').val("-1"); $('#h2').val("-1"); $('#c2').val(0); cont_dis-=1; $('#f2id').val(0); clase2=0; break;
  		case 1: $('#fila1').css("visibility","hidden"); $('#h1').empty(); $('#h1').append($('<option>',{value:-1,text:'-Horario-'})); $('#n1').val("-1"); $('#h1').val("-1"); $('#c1').val(0); cont_dis-=1; $('#f2id').val(0); clase1=0; break;
  	};
  	$('#ctotal').val(complemento+clase1+clase2+clase3+clase4);
  };

	function ccomplemento(){
		if ($('#checkcomplemento').is(":checked")){
			$('#ccomplemento').val(<?php echo $ccomplemento?>);
			complemento=parseInt(<?php echo $ccomplemento?>);
		}else{
			$('#ccomplemento').val(0);
			complemento=0;
		};
		$('#ctotal').val(complemento+clase1+clase2+clase3+clase4);
	};

  var clases=<?php echo json_encode($clases);?>;
  function sel_nombre(num){
  	switch(num){
  		case 1:
  			$('#h1').empty();
  			n1=$('#n1').val();
	  		l=2;
	  		while (clases[n1][l]) {
	  			$('#h1').append($('<option>',{value:l,text:clases[n1][l]}));
	  			l+=1;
	  		};
	  		$('#c1').val(clases[n1][1]);
	  		clase1=parseInt(clases[n1][1]);
  			$('#f1id').val(clases[n1][-1]);
	  	break;
  		case 2:
  			$('#h2').empty();
  			n2=$('#n2').val();
	  		l=2;
	  		while (clases[n2][l]) {
	  			$('#h2').append($('<option>',{value:l,text:clases[n2][l]}));
	  			l+=1;
	  		};
	  		$('#c2').val(clases[n2][1]);
	  		clase2=parseInt(clases[n2][1]);
  			$('#f2id').val(clases[n2][-1]);
	  	break;
  		case 3:
  			$('#h3').empty();
  			n3=$('#n3').val();
	  		l=2;
	  		while (clases[n3][l]) {
	  			$('#h3').append($('<option>',{value:l,text:clases[n3][l]}));
	  			l+=1;
	  		};
	  		$('#c3').val(clases[n3][1]);
	  		clase3=parseInt(clases[n3][1]);
  			$('#f3id').val(clases[n3][-1]);
	  	break;
  		case 4:
  			$('#h4').empty();
  			n4=$('#n4').val();
	  		l=2;
	  		while (clases[n4][l]) {
	  			$('#h4').append($('<option>',{value:l,text:clases[n4][l]}));
	  			l+=1;
	  		};
	  		$('#c4').val(clases[n4][1]);
	  		clase4=parseInt(clases[n4][1]);
  			$('#f4id').val(clases[n4][-1]);
	  	break;
  	};
  	$('#ctotal').val(complemento+clase1+clase2+clase3+clase4);
  };



var dcomplemento=0;
var dclase1=0;
var dclase2=0;
var dclase3=0;
var dclase4=0;

var dcont_dis=0;
  function dnueva_disciplina(){
  	switch (dcont_dis){
  		case 0: $('#dfila1').css("visibility","visible"); dcont_dis+=1;;break;
  		case 1: $('#dfila2').css("visibility","visible"); dcont_dis+=1; break;
  		case 2: $('#dfila3').css("visibility","visible"); dcont_dis+=1; break;
  		case 3: $('#dfila4').css("visibility","visible"); dcont_dis+=1; break;
  	};
  };

  function dquitar_disciplina(){
  	switch (dcont_dis){
  		case 4: $('#dfila4').css("visibility","hidden"); $('#dh4').empty(); $('#dh4').append($('<option>',{value:-1,text:'-Horario-'})); $('#dn4').val("-1"); $('#dh4').val("-1"); $('#dc4').val(0); dcont_dis-=1; $('#df1id').val(0); dclase4=0; break;
  		case 3: $('#dfila3').css("visibility","hidden"); $('#dh3').empty(); $('#dh3').append($('<option>',{value:-1,text:'-Horario-'})); $('#dn3').val("-1"); $('#dh3').val("-1"); $('#dc3').val(0); dcont_dis-=1; $('#df2id').val(0); dclase3=0; break;
  		case 2: $('#dfila2').css("visibility","hidden"); $('#dh2').empty(); $('#dh2').append($('<option>',{value:-1,text:'-Horario-'})); $('#dn2').val("-1"); $('#dh2').val("-1"); $('#dc2').val(0); dcont_dis-=1; $('#df2id').val(0); dclase2=0; break;
  		case 1: $('#dfila1').css("visibility","hidden"); $('#dh1').empty(); $('#dh1').append($('<option>',{value:-1,text:'-Horario-'})); $('#dn1').val("-1"); $('#dh1').val("-1"); $('#dc1').val(0); dcont_dis-=1; $('#df2id').val(0); dclase1=0; break;
  	};
  	$('#dctotal').val(dcomplemento+dclase1+dclase2+dclase3+dclase4);
  };

	function dccomplemento(){
		if ($('#dcheckcomplemento').is(":checked")){
			$('#dccomplemento').val(<?php echo $ccomplemento?>);
			dcomplemento=parseInt(<?php echo $ccomplemento?>);
		}else{
			$('#dccomplemento').val(0);
			dcomplemento=0;
		};
		$('#dctotal').val(dcomplemento+dclase1+dclase2+dclase3+dclase4);
	};

  var dclases=<?php echo json_encode($clases);?>;
  function dsel_nombre(num){
  	switch(num){
  		case 1:
  			$('#dh1').empty();
  			n1=$('#dn1').val();
	  		l=2;
	  		while (dclases[n1][l]) {
	  			$('#dh1').append($('<option>',{value:l,text:dclases[n1][l]}));
	  			l+=1;
	  		};
	  		$('#dc1').val(dclases[n1][1]);
	  		dclase1=parseInt(dclases[n1][1]);
  			$('#df1id').val(dclases[n1][-1]);
	  	break;
  		case 2:
  			$('#dh2').empty();
  			n2=$('#dn2').val();
	  		l=2;
	  		while (dclases[n2][l]) {
	  			$('#dh2').append($('<option>',{value:l,text:dclases[n2][l]}));
	  			l+=1;
	  		};
	  		$('#dc2').val(dclases[n2][1]);
	  		dclase2=parseInt(dclases[n2][1]);
  			$('#df2id').val(dclases[n2][-1]);
	  	break;
  		case 3:
  			$('#dh3').empty();
  			n3=$('#dn3').val();
	  		l=2;
	  		while (dclases[n3][l]) {
	  			$('#dh3').append($('<option>',{value:l,text:dclases[n3][l]}));
	  			l+=1;
	  		};
	  		$('#dc3').val(dclases[n3][1]);
	  		dclase3=parseInt(dclases[n3][1]);
  			$('#df3id').val(dclases[n3][-1]);
	  	break;
  		case 4:
  			$('#dh4').empty();
  			n4=$('#dn4').val();
	  		l=2;
	  		while (dclases[n4][l]) {
	  			$('#dh4').append($('<option>',{value:l,text:dclases[n4][l]}));
	  			l+=1;
	  		};
	  		$('#dc4').val(dclases[n4][1]);
	  		dclase4=parseInt(dclases[n4][1]);
  			$('#df4id').val(dclases[n4][-1]);
	  	break;
  	};
  	$('#dctotal').val(dcomplemento+dclase1+dclase2+dclase3+dclase4);
  };

  
  function agregarFrmActualizar(usuario){
    $.ajax({
      type:"POST",
      data:"accion=8 & usuario_d=" + usuario,
      url:"bd.php",
      success:function(r){
        datos=jQuery.parseJSON(r);
        if ($.isEmptyObject(datos[0]['foto'])){
            $('#cliente-foto').attr("src","Uploads/anonimo.jpg");
        }else{
            $('#cliente-foto').attr("src","Uploads/"+datos[0]['foto']);
        };
        $('#usuarioU').val(datos[0]['usuario']);
        $('#emailU').val(datos[0]['email']);
        $('#nombreU').val(datos[0]['nombre']);
        $('#apellidoU').val(datos[0]['apellido']);
        $('#fecha_nacU').val(datos[0]['fecha_nac']);
        $('#dniU').val(datos[0]['dni']);
        $('#celularU').val(datos[0]['celular']);
        $('#alturaU').val(datos[0]['altura']);
        $('#pesoU').val(datos[0]['peso']);
        $('#tallaU').val(datos[0]['talla']);
        if (datos[0]['id_clase']==0){
          $('#dcheckcomplemento').prop('checked',true);
          dccomplemento();
          h=1;
        }else{h=0;}
        q=1;
        cantdis=datos.length-h;
        while(datos[h]){
          if (cantdis>dcont_dis){
            dnueva_disciplina();
          };
          $('#dn'+q+' option:contains('+datos[h]['nombre_clase']+')').prop('selected', true);
          dsel_nombre(q);
          h+=1; q+=1;
        };
      }
    });
  }
</script>
<style type="text/css">
.popover {z-index: 10000006;}

.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}
.switch input {display:none;}
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}
.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}
input:checked + .slider {
  background-color: #2196F3;
}
input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}
input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}
.slider.round {
  border-radius: 34px;
}
.slider.round:before {
  border-radius: 50%;
}
</style>

<script>
$(document).ready(function(){
    $('#popover-eliminar').popover({
    	title: "<div class='d-flex justify-content-center'>Está por eliminar un cliente ¿Desea continuar?</div>",
    	content: "<div class='d-flex justify-content-center'><button type='submit' form='cliente-formulario' class='btn btn-warning' name='cliente-boton-eliminar'>Confirmar</button></div>",
    	html: true,
    	placement: "right"}); 
});
</script>

<script src="js/multi-step-modal.js"></script>
<script>
function sendEvent(modal,step) {
    $('#'+modal).trigger('next.m.'+step);
}
</script>
<style>img[alt="www.000webhost.com"]{display:none}</style>﻿
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>