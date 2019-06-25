<?php
session_start();
$db_host="localhost";
$db_usuario="id5245865_ianv97";
$db_clave="g7energymg7";
$db_nombre="id5245865_energym";
$conexion=new PDO("mysql:host=$db_host; dbname=$db_nombre","$db_usuario","$db_clave");
$conexion->exec("SET CHARACTER SET utf8");

function login($usuario,$contraseña, $conexion) {
	if (!empty($usuario) || !empty($contraseña)){
		$qry="SELECT contraseña, nivel_acceso, sucursal FROM Usuario WHERE usuario=?";
		$resultado=$conexion->prepare($qry);
		$resultado->execute(array($usuario));
		if ($resultado->errorCode()=='00000'){
			$row=$resultado->fetch(PDO::FETCH_ASSOC);
			if (password_verify ($contraseña,$row['contraseña'])){
				$_SESSION["usuario"] = $usuario;
				$_SESSION["nacceso"] = $row["nivel_acceso"];
				$_SESSION["sucursal"] = $row["sucursal"];
				return "Exito";
			}else{
				return "Error";
			};
		};
	};
};

function ver_ej ($usuario_r, $id_r, $conexion) {
$qry="SELECT nombre_categoría, ejercicio1, ejercicio2, ejercicio3, ejercicio4, ejercicio5, ejercicio6, ejercicio1s, ejercicio1r, ejercicio2s, ejercicio2r, ejercicio3s, ejercicio3r, ejercicio4s, ejercicio4r, ejercicio5s, ejercicio5r, ejercicio6s, ejercicio6r FROM Rutina
INNER JOIN Categoría ON Rutina.categoría=id_categoría
WHERE usuario_rutina=? AND id_rutina=?";
$resultado=$conexion->prepare($qry);
$resultado->execute(array($usuario_r,$id_r));
$datos=$resultado->fetch(PDO::FETCH_BOTH);
return $datos;
};

function cambiar_contraseña ($ncontraseña, $rncontraseña, $acontraseña, $conexion){
if ($ncontraseña==$rncontraseña){
	$qry="SELECT contraseña FROM Usuario
	WHERE usuario=?";
	$resultado=$conexion->prepare($qry);
	$resultado->execute(array($_SESSION["usuario"]));
	$row=$resultado->fetch(PDO::FETCH_ASSOC);
	if (password_verify($acontraseña,$row["contraseña"])){
		$qry="UPDATE Usuario
		SET contraseña=?
		WHERE usuario=?";
		$resultado=$conexion->prepare($qry);
		$resultado->execute(array(password_hash($ncontraseña,PASSWORD_DEFAULT),$_SESSION["usuario"]));
		if ($resultado->errorCode()=='00000'){
			$msj="Contraseña actualizada";
		}else{
			$msj="Error en la Base de datos";
		};
	}else{
		$msj="La contraseña ingresada es incorrecta";
	};
}else{
	$msj="Los campos contraseña y repetir contraseña no coinciden";
};
return $msj;
};

function ver_asistencia ($finicio, $ffin, $conexion) {
$qry="SELECT Asistencia.sucursal AS sucursal,fecha,apellido,nombre,presente FROM Asistencia
INNER JOIN Usuario ON Asistencia.usuario=Usuario.usuario
WHERE Asistencia.fecha>=? AND Asistencia.fecha<=? 
ORDER BY sucursal,fecha,apellido,nombre";
$resultado=$conexion->prepare($qry);
$resultado->execute(array($finicio,$ffin));
$datos=$resultado->fetchall(PDO::FETCH_ASSOC);
return $datos;
};

function ver_asistenciatot ($finicio, $ffin, $conexion) {
$qry="SELECT nombre,apellido,COUNT(CASE WHEN presente=1 AND fecha BETWEEN ? AND ? THEN 1 END) AS presente,COUNT(CASE WHEN fecha BETWEEN ? AND ? THEN 1 END) AS total,ROUND((COUNT(CASE WHEN presente=1 AND fecha BETWEEN ? AND ? THEN 1 END)/COUNT(CASE WHEN fecha BETWEEN ? AND ? THEN 1 END)*100),0) AS porcentaje FROM Usuario, Asistencia
WHERE Asistencia.usuario=Usuario.usuario
GROUP BY apellido, nombre
ORDER BY apellido,nombre";
$resultado=$conexion->prepare($qry);
$resultado->execute(array($finicio,$ffin,$finicio,$ffin,$finicio,$ffin,$finicio,$ffin));
$datos=$resultado->fetchall(PDO::FETCH_ASSOC);
return $datos;
};

function ver_asistenciaemp ($finicio, $ffin, $conexion) {
$qry="SELECT AsistenciaEmpleado.sucursal AS sucursal,fecha,apellido,nombre,presente,ROUND((horasalida-horaingreso)/10000,1) AS horast FROM AsistenciaEmpleado
INNER JOIN Usuario ON AsistenciaEmpleado.usuario=Usuario.usuario
WHERE AsistenciaEmpleado.fecha>=? AND AsistenciaEmpleado.fecha<=? 
ORDER BY sucursal,fecha,apellido,nombre";
$resultado=$conexion->prepare($qry);
$resultado->execute(array($finicio,$ffin));
$datos=$resultado->fetchall(PDO::FETCH_ASSOC);
return $datos;
};

function ver_asistenciaemptot ($finicio, $ffin, $conexion) {
$qry="SELECT nombre,apellido,COUNT(CASE WHEN presente=1 AND fecha BETWEEN ? AND ? THEN 1 END) AS presente,COUNT(CASE WHEN fecha BETWEEN ? AND ? THEN 1 END) AS total,ROUND((COUNT(CASE WHEN presente=1 AND fecha BETWEEN ? AND ? THEN 1 END)/COUNT(CASE WHEN fecha BETWEEN ? AND ? THEN 1 END)*100),0) AS porcentaje, SUM(ROUND((horasalida-horaingreso)/10000,1)) AS horast FROM Usuario, AsistenciaEmpleado
WHERE AsistenciaEmpleado.usuario=Usuario.usuario
GROUP BY nombre, apellido
ORDER BY apellido,nombre";
$resultado=$conexion->prepare($qry);
$resultado->execute(array($finicio,$ffin,$finicio,$ffin,$finicio,$ffin,$finicio,$ffin));
$datos=$resultado->fetchall(PDO::FETCH_ASSOC);
return $datos;
};

function ver_cliente ($usuario, $conexion){
$qry="SELECT Usuario.usuario AS usuario,email,Usuario.nombre AS nombre,apellido,fecha_nac,sexo,foto,dni,celular,altura,peso,talla,Clases.id_clase AS id_clase,Clases.nombre AS nombre_clase FROM Usuario
INNER JOIN Pack ON Usuario.usuario=Pack.usuario
INNER JOIN PackClase ON Pack.id_pack=PackClase.id_pack
INNER JOIN Clases ON PackClase.id_clase=Clases.id_clase
WHERE Usuario.usuario=?
ORDER BY id_clase";
$resultado=$conexion->prepare($qry);
$resultado->execute(array($usuario));
$row=$resultado->fetchall(PDO::FETCH_BOTH);
return $row;
};

function modal_asistencia ($usuario, $conexion){
$qry="SELECT usuario,apellido,nombre,dni,foto,nivel_acceso FROM Usuario WHERE usuario=? OR dni=?";
$resultado=$conexion->prepare($qry);
$resultado->execute(array($usuario,$usuario));
$row=$resultado->fetch(PDO::FETCH_ASSOC);
return $row;
};

function modal_cuota ($usuario, $conexion){
$qry="SELECT id_cuota,DATE_FORMAT(periodo,'%Y-%m') AS periodo,precio FROM Cuota WHERE usuario=? AND pagada=0 ORDER BY periodo";
$resultado=$conexion->prepare($qry);
$resultado->execute(array($usuario));
$row=$resultado->fetchall(PDO::FETCH_BOTH);
return $row;
};

function ver_empleado ($usuario, $conexion){
$qry="SELECT * FROM Usuario WHERE usuario=?";
$resultado=$conexion->prepare($qry);
$resultado->execute(array($usuario));
$row=$resultado->fetch(PDO::FETCH_ASSOC);
return $row;
};

function ver_categoria($id_cat){
$qry="SELECT * FROM Categoría WHERE id_categoría=?";
$resultado=$conexion->prepare($qry);
$resultado->execute(array($id_cat));
$row=$resultado->fetch(PDO::FETCH_ASSOC);
return $row;
};

switch($_POST["accion"]){
	case 1: echo json_encode(login($_POST["ingresousuario"],$_POST["ingresocontraseña"], $conexion)); break;
	case 2: echo json_encode(ver_ej($_POST["usuario_r"], $_POST["id_r"], $conexion)); break;
	case 3: echo (cambiar_contraseña($_POST["ncontraseña"],$_POST["rncontraseña"],$_POST["acontraseña"],$conexion)); break;
	case 4: echo json_encode(ver_asistencia($_POST["asistencia-finicio"], $_POST["asistencia-ffin"], $conexion)); break;
	case 5: echo json_encode(ver_asistenciatot($_POST["asistenciatot-finicio"], $_POST["asistenciatot-ffin"], $conexion)); break;
	case 6: echo json_encode(ver_asistenciaemp($_POST["asistenciaemp-finicio"], $_POST["asistenciaemp-ffin"], $conexion)); break;
	case 7: echo json_encode(ver_asistenciaemptot($_POST["asistenciaemptot-finicio"], $_POST["asistenciaemptot-ffin"], $conexion)); break;
	case 8: echo json_encode(ver_cliente($_POST["usuario_d"], $conexion)); break;
	case 9: echo json_encode(modal_asistencia($_POST["usuario_d"], $conexion)); break;
	case 10: echo json_encode(modal_cuota($_POST["usuarioc"], $conexion)); break;
	case 11: echo json_encode(ver_empleado($_POST["usuarioe"], $conexion)); break;
	case 12: echo json_encode(ver_categoria($_POST["id_cat"], $conexion)); break;

}
?>