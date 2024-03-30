<?php session_start(); // En todas las páginas que trabajamos con $_SESSION debemos tener session_start()

// Comprobamos tenga sesión, sino entonces redirigimos y matamos la ejecución de la página.
if (isset($_SESSION['usuario'])) {
	require 'views/contenido.view.php';
} else {
	header('Location: login.php'); // A que se registre o inicie sesión.
	die();
}

// Solo accederá al contenido el usuario siempre y cuando tenga la sesión iniciada.
// Lo interesante es que si tratamos de acceder directamente por url al contenido de contenido.php no nos deja acceder, solo podremos acceder si estamos logueados con un usuario que hayamos registrado previamente a través del formulario.
?>