<?php session_start();

// Comprobamos que el usuario tenga una sesión, sino entonces redirigimos a la página de registro. Si tiene una sesión entonces lo enviamos a que acceda al contenido.
if(isset($_SESSION['usuario'])) {
	header('Location: contenido.php');
	die(); /* Matamos la ejecución de la página. */
} else {
	// Enviamos al usuario al formulario de registro.
	header('Location: registrate.php');
}

?>