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
	<title>Energym - Rutinas</title>
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
  };
};

if (isset($_POST["rutina-boton-eliminar"])){
	$qry="UPDATE Rutina SET fecha_fin=CURDATE() WHERE id_rutina=?";
	$resultado=$conexion->prepare($qry);
	$resultado->execute(array($_POST['idrut']));
};

if (isset($_POST['rutina-botonañadir'])){
	if (empty($_POST['nsej1'])){$s1=NULL;$r1=NULL;}else{$s1=$_POST['nsej1'];$r1=$_POST['nrej1'];};
	if (empty($_POST['nsej2'])){$s2=NULL;$r2=NULL;}else{$s2=$_POST['nsej2'];$r2=$_POST['nrej2'];};
	if (empty($_POST['nsej3'])){$s3=NULL;$r3=NULL;}else{$s3=$_POST['nsej3'];$r3=$_POST['nrej3'];};
	if (empty($_POST['nsej4'])){$s4=NULL;$r4=NULL;}else{$s4=$_POST['nsej4'];$r4=$_POST['nrej4'];};
	if (empty($_POST['nsej5'])){$s5=NULL;$r5=NULL;}else{$s5=$_POST['nsej5'];$r5=$_POST['nrej5'];};
	if (empty($_POST['nsej6'])){$s6=NULL;$r6=NULL;}else{$s6=$_POST['nsej6'];$r6=$_POST['nrej6'];};
	$qry="INSERT INTO Rutina (usuario_rutina, fecha_inicio, profesor, dia_rutina, categoría, ejercicio1s, ejercicio1r, ejercicio2s, ejercicio2r, ejercicio3s, ejercicio3r, ejercicio4s, ejercicio4r, ejercicio5s, ejercicio5r, ejercicio6s, ejercicio6r) VALUES (?, CURDATE(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
	$resultado=$conexion->prepare($qry);
	$resultado->execute(array($_POST['rutinausuario'], $_SESSION['usuario'], $_POST['diarut'], $_POST['ncategoria'], $s1, $r1, $s2, $r2, $s3, $r3, $s4, $r4, $s5, $r5, $s6, $r6));
	if ($resultado->errorCode()=='00000'){
		echo "<script>alert('Rutina añadida con éxito');</script>";
	};
};

?>


<?php
$qry="SELECT * FROM Categoría";
$resultado=$conexion->prepare($qry);
$resultado->execute();
$arrcategoria=$resultado->fetchall(PDO::FETCH_ASSOC);

$usuario=$_POST['rutinausuario'];
$qry="SELECT nombre,apellido FROM Usuario WHERE usuario=?";
$resultado=$conexion->prepare($qry);
$resultado->execute(array($usuario));
$row=$resultado->fetch(PDO::FETCH_ASSOC);
$nyacliente=$row['nombre'].' '.$row['apellido'];
$qry="SELECT usuario_rutina, id_rutina, fecha_inicio, fecha_fin, dia_rutina, nombre_categoría, nombre, apellido FROM Rutina
INNER JOIN Usuario ON Rutina.profesor=Usuario.usuario
INNER JOIN Categoría ON Rutina.categoría=Categoría.id_categoría
WHERE usuario_rutina=?";
$resultado=$conexion->prepare($qry);
$resultado->execute(array($usuario));
?>

<header>
  <nav class="navbar navbar-expand-lg bg-dark barramenu">
    <img class="img-responsive mr-2" src="../imagen/logo.svg" alt="logo eg"/>
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

<div class="card col-9 col-xl-10" id="rutinas-card" style="z-index: 10000000;">
  <div class="card-body">
    <h5 class="card-title text-center" id="rutinas-card-titulo">Rutinas de <?php echo $nyacliente ?></h5>
    <div class="row">
    	<div style="position:absolute;">
	    	<label style="font-weight:bold; font-size:20px;" class="align-top ml-4 mr-1">Mostrar rutinas finalizadas</label>
	    	<label class="switch" onclick="cambiarfiltro()">
				<input form="registro-formulario" type="checkbox" id="checkfiltro" name="checkfiltro">
				<span class="slider round" onclick="cambiarfiltro()"></span>
			</label>
		</div>
      	<button type="button" class="btn btn-primary col-4 col-lg-3 col-xl-2 offset-8 offset-lg-9 offset-xl-10 mb-3" data-toggle="modal" data-target="#nuevarutina" onclick="nueva_rutina()"><span class="fas fa-plus-square"></span>  Nueva Rutina</button>
    </div>
    <div class="table-responsive">
      <table class="table table-hover text-center" id="rutinas-tabla">
        <thead class="bg-dark" style="color:white; font-weight:bold;">
          <tr>
            <td>Fecha de Inicio</td>
            <td>Fecha de Fin</td>
            <td>Día asignado</td>
            <td>Categoría</td>
            <td>Profesor</td>
            <td>Ejercicios</td>
          </tr>
        </thead>
        <tfoot class="bg-primary" style="color:white; font-weight:bold;">
          <tr>
            <td>Fecha de Inicio</td>
            <td>Fecha de Fin</td>
            <td>Día asignado</td>
            <td>Categoría</td>
            <td>Profesor</td>
            <td>Ejercicios</td>
          </tr>
        </tfoot>
        <tbody>
          <?php
          while ($row=$resultado->fetch(PDO::FETCH_BOTH)) {
          ?>
          <tr>
            <td><?php echo $row['fecha_inicio'] ?></td>
            <td><?php if(empty($row['fecha_fin'])){echo "_";}else{echo $row['fecha_fin'];}; ?></td>
            <td><?php echo $row['dia_rutina'] ?></td>
            <td><?php echo $row['nombre_categoría'] ?></td>
            <td><?php echo $row['nombre'].' '.$row['apellido'] ?></td>
            <td>
              <span class="btn btn-warning" data-toggle="modal" data-target="#verejercicios" onclick="ver_ej('<?php echo $row[0] ?>',<?php echo $row[1] ?>,'<?php echo $row[3] ?>')">
                <i class="fas fa-eye"></i>
              </span>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>


<div class="modal fade" id="verejercicios" tabindex="-1" role="dialog" aria-hidden="true" style="z-index:10000004;">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content" style="margin-left:-6vw;">
			<div class="modal-header">
				<h5 class="modal-title" id="titulomodal"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style="background-image: url(https://energym.tk/imagen/fondo_formulario.jpg);">
				<form method="post" action="" id="form-modal" enctype="multipart/form-data">
					<input type="hidden" id="idrut" name="idrut">
					<input type="hidden" id="rutinausuario" name="rutinausuario" value="<?php echo $_POST['rutinausuario'] ?>"/>
				</form>
				<div class="row">
					<label class="subtmod col-4 ml-5" id="ejmod" style="color:white;">Ejercicio</label>
					<label class="subtmod col-2 ml-4" style="color:white;">Series</label>
					<label class="subtmod col-2 ml-4" style="color:white;">Repeticiones</label>
				</div>
				<div class="row align-middle" id="f1">
					<label id="nej1" class="nom col-5" style="color:white;"></label>
					<label class="col-3"><input type="text" class="form-control mx-3 ser" id="sej1" name="sej1" readonly="true"></label>
					<label class="col-3"><input type="text" class="form-control mx-3 rep" id="rej1" name="rej1" readonly="true"></label>
				</div>
				<div class="row align-middle" id="f2">
					<label id="nej2" class="nom col-5" style="color:white;"></label>
					<label class="col-3"><input type="text" class="form-control mx-3 ser" id="sej2" name="sej2" readonly="true"></label>
					<label class="col-3"><input type="text" class="form-control mx-3 rep" id="rej2" name="rej2" readonly="true"></label>
				</div>
				<div class="row align-middle" id="f3">
					<label id="nej3" class="nom col-5" style="color:white;"></label>
					<label class="col-3"><input type="text" class="form-control mx-3 ser" id="sej3" name="sej3" readonly="true"></label>
					<label class="col-3"><input type="text" class="form-control mx-3 rep" id="rej3" name="rej3" readonly="true"></label>
				</div>
				<div class="row align-middle" id="f4">
					<label id="nej4" class="nom col-5" style="color:white;"></label>
					<label class="col-3"><input type="text" class="form-control mx-3 ser" id="sej4" name="sej4" readonly="true"></label>
					<label class="col-3"><input type="text" class="form-control mx-3 rep" id="rej4" name="rej4" readonly="true"></label>
				</div>
				<div class="row align-middle" id="f5">
					<label id="nej5" class="nom col-5" style="color:white;"></label>
					<label class="col-3"><input type="text" class="form-control mx-3 ser" id="sej5" name="sej5" readonly="true"></label>
					<label class="col-3"><input type="text" class="form-control mx-3 rep" id="rej5" name="rej5" readonly="true"></label>
				</div>
				<div class="row align-middle" id="f6">
					<label id="nej6" class="nom col-5" style="color:white;"></label>
					<label class="col-3"><input type="text" class="form-control mx-3 ser" id="sej6" name="sej6" readonly="true"></label>
					<label class="col-3"><input type="text" class="form-control mx-3 rep" id="rej6" name="rej6" readonly="true"></label>
				</div> 
			</div>
			<div class="modal-footer bg-dark d-flex justify-content-center">
				<div class="row">
					<button type="button" form="form-modal" class="btn btn-danger mr-5" id="popover-eliminar"><i class="fa fa-times"></i> Eliminar</button>
					<button type="button" class="btn btn-secondary ml-5" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="nuevarutina" tabindex="-1" role="dialog" aria-hidden="true" style="z-index:10000004;">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content" style="margin-left:-6vw;">
			<div class="modal-header">
				<h5 class="modal-title">Nueva Rutina</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style="background-image: url(https://energym.tk/imagen/fondo_formulario.jpg);">
				<form method="post" action="" id="form-modal" name="form-modal" enctype="multipart/form-data"></form>
				<input type="hidden" form="form-modal" name="ncategoria" id="ncategoria">
				<input type="hidden" form="form-modal" name="diarut" id="diarut">
				<div class="row d-flex justify-content-center my-3">
					<label class="mr-2" style="font-weight:bold; font-size:18px; color:white;">Categoría:</label>
					<select class="form-control" id="categoriaelegida" onchange="nueva_rutina()" style="width:160px;">
						<option value='9'>-Categoría-</option>
						<?php $t=0;
						while (isset($arrcategoria[$t])){
						?>
						<option value="<?php echo $t ?>"><?php echo $arrcategoria[$t]['nombre_categoría'];$t+=1;}; ?></option>
					</select>
				</div>
				<div class="row d-flex justify-content-center my-3">
					<label class="mr-2" style="font-weight:bold; font-size:18px; color:white;">Día asignado:</label>
					<select class="form-control" id="diaelegido" onchange="asignardia()" style="width:130px;">
						<option>-Día-</option>
						<option>Lunes</option>
						<option>Martes</option>
						<option>Miércoles</option>
						<option>Jueves</option>
						<option>Viernes</option>
						<option>Sábado</option>
					</select>
				</div>
				<div class="row">
					<label class="subtmod col-4 ml-5" id="ejmod" style="color:white;">Ejercicio</label>
					<label class="subtmod col-2 ml-4" style="color:white;">Series</label>
					<label class="subtmod col-2 ml-4" style="color:white;">Repeticiones</label>
				</div>
				<div class="row align-middle" id="nf1">
					<label id="nnej1" class="nom col-5" style="color:white;"></label>
					<label class="col-3"><input type="text" form="form-modal" class="form-control mx-3 ser" id="nsej1" name="nsej1"></label>
					<label class="col-3"><input type="text" form="form-modal" class="form-control mx-3 rep" id="nrej1" name="nrej1"></label>
				</div>
				<div class="row align-middle" id="nf2">
					<label id="nnej2" class="nom col-5" style="color:white;"></label>
					<label class="col-3"><input type="text" form="form-modal" class="form-control mx-3 ser" id="nsej2" name="nsej2"></label>
					<label class="col-3"><input type="text" form="form-modal" class="form-control mx-3 rep" id="nrej2" name="nrej2"></label>
				</div>
				<div class="row align-middle" id="nf3">
					<label id="nnej3" class="nom col-5" style="color:white;"></label>
					<label class="col-3"><input type="text" form="form-modal" class="form-control mx-3 ser" id="nsej3" name="nsej3"></label>
					<label class="col-3"><input type="text" form="form-modal" class="form-control mx-3 rep" id="nrej3" name="nrej3"></label>
				</div>
				<div class="row align-middle" id="nf4">
					<label id="nnej4" class="nom col-5" style="color:white;"></label>
					<label class="col-3"><input type="text" form="form-modal" class="form-control mx-3 ser" id="nsej4" name="nsej4"></label>
					<label class="col-3"><input type="text" form="form-modal" class="form-control mx-3 rep" id="nrej4" name="nrej4"></label>
				</div>
				<div class="row align-middle" id="nf5">
					<label id="nnej5" class="nom col-5" style="color:white;"></label>
					<label class="col-3"><input type="text" form="form-modal" class="form-control mx-3 ser" id="nsej5" name="nsej5"></label>
					<label class="col-3"><input type="text" form="form-modal" class="form-control mx-3 rep" id="nrej5" name="nrej5"></label>
				</div>
				<div class="row align-middle" id="nf6">
					<label id="nnej6" class="nom col-5" style="color:white;"></label>
					<label class="col-3"><input type="text" form="form-modal" class="form-control mx-3 ser" id="nsej6" name="nsej6"></label>
					<label class="col-3"><input type="text" form="form-modal" class="form-control mx-3 rep" id="nrej6" name="nrej6"></label>
				</div>
			</div>
			<div class="modal-footer bg-dark d-flex justify-content-center">
				<div class="row">
					<button type="submit" form="form-modal" class="btn btn-primary" id="rutina-botonañadir" name="rutina-botonañadir" style="font-weight:bold;"><i class="fa fa-plus-square"></i> Añadir</button>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
var tabla;
$(document).ready(function() {
tabla=$('#rutinas-tabla').DataTable( {
        "order": [[ 0, "desc" ]],
        "language": {
            "emptyTable": "Tabla vacía",
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No hay coincidencias con el criterio de búsqueda",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "infoEmpty": "No hay registros para mostrar",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Búsqueda:",
            "paginate": {
              "next": "Siguiente",
              "previous": "Anterior"
            }
        }
    } );
cambiarfiltro();
});

function cambiarfiltro(){
	if ($('#checkfiltro').is(":checked")){
		tabla.columns(1).visible(true);
		tabla.column(1).search(' ');
		tabla.draw();
	}else{
		tabla.columns(1).visible(false);
		tabla.column(1).search('_');
		tabla.draw();
	};
};

$(document).ready(function(){
    $('#popover-eliminar').popover({
    	title: "<div class='d-flex justify-content-center'>Está por dar de baja una rutina ¿Desea continuar?</div>",
    	content: "<div class='d-flex justify-content-center'><button type='submit' form='form-modal' class='btn btn-warning' name='rutina-boton-eliminar'>Confirmar</button></div>",
    	html: true,
    	placement: "right"}); 
});
</script>

<script type="text/javascript">
function ver_ej(usuario_r, id_r,ffin){
    $.ajax({
      type:"POST",
      data:"accion=2 & usuario_r="+usuario_r+" & id_r="+id_r,
      url:"bd.php",
      success:function(r){
        datos=jQuery.parseJSON(r);
        $('#titulomodal').text("Ejercicios de " + datos['nombre_categoría']);
        if (datos['ejercicio1r']!=null){
        	$('#nej1').text(datos['ejercicio1']);
        	$('#sej1').val(datos['ejercicio1s']);
        	$('#rej1').val(datos['ejercicio1r']);
        	$('#f1').show();
        }else{
        	$('#f1').hide();
        };
        if (datos['ejercicio2r']!=null){
        	$('#nej2').text(datos['ejercicio2']);
        	$('#sej2').val(datos['ejercicio2s']);
        	$('#rej2').val(datos['ejercicio2r']);
        	$('#f2').show();
        }else{
        	$('#f2').hide();
        };
        if (datos['ejercicio3r']!=null){
        	$('#nej3').text(datos['ejercicio3']);
        	$('#sej3').val(datos['ejercicio3s']);
        	$('#rej3').val(datos['ejercicio3r']);
        	$('#f3').show();
        }else{
        	$('#f3').hide();
        };
        if (datos['ejercicio4r']!=null){
        	$('#nej4').text(datos['ejercicio4']);
        	$('#sej4').val(datos['ejercicio4s']);
        	$('#rej4').val(datos['ejercicio4r']);
        	$('#f4').show();
        }else{
        	$('#f4').hide();
        };
        if (datos['ejercicio5r']!=null){
        	$('#nej5').text(datos['ejercicio5']);
        	$('#sej5').val(datos['ejercicio5s']);
        	$('#rej5').val(datos['ejercicio5r']);
        	$('#f5').show();
        }else{
        	$('#f5').hide();
        };
        if (datos['ejercicio6r']!=null){
        	$('#nej6').text(datos['ejercicio6']);
        	$('#sej6').val(datos['ejercicio6s']);
        	$('#rej6').val(datos['ejercicio6r']);
        	$('#f6').show();
        }else{
        	$('#f6').hide();
        };
      },
      error:function(){
        console.log('Error');
      }
    });
    $('#idrut').val(id_r);
    if (ffin.length!=0){
    	$('#popover-eliminar').prop("disabled",true);
    }else{
    	$('#popover-eliminar').removeProp("disabled");
    };
};


function nueva_rutina(){
var catelegida=parseInt($('#categoriaelegida option:selected').val());
$('#nsej1').empty();
$('#nrej1').empty();
$('#nsej2').empty();
$('#nrej2').empty();
$('#nsej3').empty();
$('#nrej3').empty();
$('#nsej4').empty();
$('#nrej4').empty();
$('#nsej5').empty();
$('#nrej5').empty();
$('#nsej6').empty();
$('#nrej6').empty();
switch (catelegida){
	case 0:
	$('#nnej1').text("<?php echo $arrcategoria[0]['ejercicio1']; ?>");
	$('#nnej2').text("<?php echo $arrcategoria[0]['ejercicio2']; ?>");
	$('#nnej3').text("<?php echo $arrcategoria[0]['ejercicio3']; ?>");
	$('#nnej4').text("<?php echo $arrcategoria[0]['ejercicio4']; ?>");
	$('#nnej5').text("<?php echo $arrcategoria[0]['ejercicio5']; ?>");
	$('#nnej6').text("<?php echo $arrcategoria[0]['ejercicio6']; ?>");
	$('#nf1').show();
	$('#nf2').show();
	$('#nf3').show();
	$('#nf4').show();
	$('#nf5').show();
	$('#nf6').show();
	break;
	case 1:
	$('#nnej1').text("<?php echo $arrcategoria[1]['ejercicio1']; ?>");
	$('#nnej2').text("<?php echo $arrcategoria[1]['ejercicio2']; ?>");
	$('#nnej3').text("<?php echo $arrcategoria[1]['ejercicio3']; ?>");
	$('#nnej4').text("<?php echo $arrcategoria[1]['ejercicio4']; ?>");
	$('#nnej5').text("<?php echo $arrcategoria[1]['ejercicio5']; ?>");
	$('#nnej6').text("<?php echo $arrcategoria[1]['ejercicio6']; ?>");
	$('#nf1').show();
	$('#nf2').show();
	$('#nf3').show();
	$('#nf4').show();
	$('#nf5').show();
	$('#nf6').show();
	break;
	case 2:
	$('#nnej1').text("<?php echo $arrcategoria[2]['ejercicio1']; ?>");
	$('#nnej2').text("<?php echo $arrcategoria[2]['ejercicio2']; ?>");
	$('#nnej3').text("<?php echo $arrcategoria[2]['ejercicio3']; ?>");
	$('#nnej4').text("<?php echo $arrcategoria[2]['ejercicio4']; ?>");
	$('#nnej5').text("<?php echo $arrcategoria[2]['ejercicio5']; ?>");
	$('#nnej6').text("<?php echo $arrcategoria[2]['ejercicio6']; ?>");
	$('#nf1').show();
	$('#nf2').show();
	$('#nf3').show();
	$('#nf4').show();
	$('#nf5').show();
	$('#nf6').show();
	break;
	case 3:
	$('#nnej1').text("<?php echo $arrcategoria[3]['ejercicio1']; ?>");
	$('#nnej2').text("<?php echo $arrcategoria[3]['ejercicio2']; ?>");
	$('#nnej3').text("<?php echo $arrcategoria[3]['ejercicio3']; ?>");
	$('#nnej4').text("<?php echo $arrcategoria[3]['ejercicio4']; ?>");
	$('#nnej5').text("<?php echo $arrcategoria[3]['ejercicio5']; ?>");
	$('#nnej6').text("<?php echo $arrcategoria[3]['ejercicio6']; ?>");
	$('#nf1').show();
	$('#nf2').show();
	$('#nf3').show();
	$('#nf4').show();
	$('#nf5').show();
	$('#nf6').show();
	break;
	case 4:
	$('#nnej1').text("<?php echo $arrcategoria[4]['ejercicio1']; ?>");
	$('#nnej2').text("<?php echo $arrcategoria[4]['ejercicio2']; ?>");
	$('#nnej3').text("<?php echo $arrcategoria[4]['ejercicio3']; ?>");
	$('#nnej4').text("<?php echo $arrcategoria[4]['ejercicio4']; ?>");
	$('#nnej5').text("<?php echo $arrcategoria[4]['ejercicio5']; ?>");
	$('#nf1').show();
	$('#nf2').show();
	$('#nf3').show();
	$('#nf4').show();
	$('#nf5').show();
	$('#nf6').hide();
	break;
	case 5:
	$('#nnej1').text("<?php echo $arrcategoria[5]['ejercicio1']; ?>");
	$('#nnej2').text("<?php echo $arrcategoria[5]['ejercicio2']; ?>");
	$('#nnej3').text("<?php echo $arrcategoria[5]['ejercicio3']; ?>");
	$('#nnej4').text("<?php echo $arrcategoria[5]['ejercicio4']; ?>");
	$('#nnej5').text("<?php echo $arrcategoria[5]['ejercicio5']; ?>");
	$('#nnej6').text("<?php echo $arrcategoria[5]['ejercicio6']; ?>");
	$('#nf1').show();
	$('#nf2').show();
	$('#nf3').show();
	$('#nf4').show();
	$('#nf5').show();
	$('#nf6').show();
	break;
	case 6:
	$('#nnej1').text("<?php echo $arrcategoria[6]['ejercicio1']; ?>");
	$('#nnej2').text("<?php echo $arrcategoria[6]['ejercicio2']; ?>");
	$('#nnej3').text("<?php echo $arrcategoria[6]['ejercicio3']; ?>");
	$('#nnej4').text("<?php echo $arrcategoria[6]['ejercicio4']; ?>");
	$('#nf1').show();
	$('#nf2').show();
	$('#nf3').show();
	$('#nf4').show();
	$('#nf5').hide();
	$('#nf6').hide();
	break;
	case 9:
	$('#nf1').hide();
	$('#nf2').hide();
	$('#nf3').hide();
	$('#nf4').hide();
	$('#nf5').hide();
	$('#nf6').hide();
};
$('#ncategoria').val(catelegida+1);
if ($('#diaelegido option:selected').text()!="-Día-" && $('#categoriaelegida option:selected').val()!=9){
	$('#rutina-botonañadir').prop("disabled",false);
}else{
	$('#rutina-botonañadir').prop("disabled",true);
};
};

function asignardia(){
$('#diarut').val($('#diaelegido option:selected').text());
if ($('#diaelegido option:selected').text()!="-Día-" && $('#categoriaelegida option:selected').val()!=9){
	$('#rutina-botonañadir').prop("disabled",false);
}else{
	$('#rutina-botonañadir').prop("disabled",true);
};
};
</script>


</body>
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
img[alt="www.000webhost.com"]{display:none}
</style>﻿
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</html>