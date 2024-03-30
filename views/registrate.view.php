<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<link href='https://fonts.googleapis.com/css?family=Raleway:400,300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/estilos.css">
	<title>Crea una cuenta</title>
</head>
<body>
	<div class="contenedor">
		<h1 class="titulo">Regístrate</h1>
		
		<hr class="border">

		<form class="formulario" name="login" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST"> <!-- Utilizamos la variable superglobal de $_SERVER y le pasamos el valor de PHP_SELF y a su vez lo usamos con la función htmlspecialchars para evitar que nos inyecten código. -->
        <!-- Separo los elementos de las 3 líneas ('Usuario', 'Contraseña' y 'Repite la contraeña'). -->

			<div class="form-group"> 
				<i class="icono izquierda fa fa-user"></i><input class="usuario" type="text" name="usuario" placeholder="Usuario">
			</div> <!-- fa fa-user hace referencia al estilo que aplicamos al icono y que proviene de los estilos css traidos de font-awesome -->

			<div class="form-group">
				<i class="icono izquierda fa fa-lock"></i><input class="password" type="password" name="password" placeholder="Contraseña">
			</div>

			<div class="form-group">
				<i class="icono izquierda fa fa-lock"></i><input class="password_btn" type="password" name="password2" placeholder="Repite la contraseña">
				<i class="submit-btn fa fa-arrow-right" onclick="login.submit()"></i> <!-- JavaScript para que cuando el usuario haga click envie el formulario, accedo al formulario con login y aplico submit. El login lo saco del name del formulario que tenemos más arriba. -->
			</div> <!-- name es password2 porque deben tener un name diferente, la clase password_btn porque la tenemos especificada en el css para que nos abarque menos espacio y poder tener al lado el botón. -->

			<!-- Comprobamos si la variable errores esta seteada, si es asi mostramos los errores -->
			<?php if(!empty($errores)): ?>
				<div class="error">
					<ul>
						<?php echo $errores; ?>
					</ul>
				</div>
			<?php endif; ?> <!-- Con la estructura del if abreviado debemos finalizarla con un endif. -->
		</form>

		<p class="texto-registrate">
			¿Ya tienes cuenta?
			<a href="login.php">Iniciar sesión</a>
		</p>

	</div>
</body>
</html>