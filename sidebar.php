<!DOCTYPE html>
<html>
<body>
<aside class="container-fluid sidebar-sticky text-white position-absolute d-flex justify-content-center bg-primary col-3 col-xl-2 lateral">
	<ul class="nav flex-column col-11 col-lg-10 col-xl-9" style="margin-right:-25px;">
		<li class="row d-flex justify-content-center">
			<h3 class="my-0 my-md-2 my-lg-3" id="iniciar-sesion">Iniciar Sesión</h3>
		</li>
		<li class="nav-item">
			<form method="post" id="ingreso-formulario" name="ingresoformulario" class="form-group my-1 my-md-2 my-lg-3">
				<div class="row d-flex justify-content-center my-1 my-md-2 my-lg-3">
	      			<input class="form-control" name="ingresousuario" type="text" placeholder="Usuario" aria-label="Usuario">
	      		</div>
	      		<div class="row d-flex justify-content-center my-1 my-md-2 my-lg-3">
	      			<input class="form-control" name="ingresocontraseña" type="password" placeholder="Contraseña" aria-label="Contraseña">
	      		</div>
	    	</form>
	    </li>
	    <li class="row d-flex justify-content-center" style="margin-top:-8px; margin-bottom:10px;">
	    	<a style="text-decoration:none; cursor: pointer;" id="popover-contraseña">¿Olvidaste tu contraseña?</a>
	    </li>
	    <li class="row d-flex justify-content-center">
			<button form="ingreso-formulario" class=" btn btn-outline-success btn-block mt-1 mb-0 px-0 px-sm-1 px-md-2 px-xl-3 bg-dark" name="ingreso-boton" id="ingreso-boton" type="submit">Ingresar</button>
		</li>
	</ul>
</aside>

<footer id="copyright">
		&copy; 2018 Energym
</footer>
<form style="display:none" id="recuperarcontraseña"></form>
<script type="text/javascript">
$(document).on('submit','#ingreso-formulario', function(event){
	event.preventDefault();
	$.ajax({
		type: 'POST',
		url: 'bd.php',
		data: "accion=1 &" + $(this).serialize(),
		success: function(r){
			location.reload();
			if (jQuery.parseJSON(r)=="Error"){alert('Usuario o contraseña incorrectos.');};
		}
	})
});


$(document).on('submit','#recuperarcontraseña', function(event){
	alert("Te hemos enviado un email con las instrucciones para recuperar tu contraseña.")
});

$(document).ready(function(){
    $('#popover-contraseña').popover({
    	title: "<div class='d-flex justify-content-center'>Ingrese su usuario o email</div>",
    	content: "<div class='row d-flex justify-content-center'><input type='email' class='form-control text-center' name='cliente-email' placeholder='Usuario o E-mail' style='width:200px;margin-bottom:10px;'></div><div class='row d-flex justify-content-center'><button type='submit' form='recuperarcontraseña' id='cambiopopover' class='btn btn-warning'>Recuperar</button></div>",
    	html: true,
    	placement: "left"
    });
});
</script>

<style type="text/css">.popover {z-index: 10000006;}</style>
</body>

</html>