<?php session_start();

// Comprobamos si ya tiene una sesión.
// Si ya tiene una sesión redirigimos al contenido, para que no pueda acceder al formulario.
// Es igual que el if de registrate.php
if (isset($_SESSION['usuario'])) {
	header('Location: index.php');
	die();
}

// Comprobamos si ya han sido enviados los datos.
if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Esto significara que los datos han sido enviados.
	$usuario = filter_var(strtolower($_POST['usuario']), FILTER_SANITIZE_STRING);
	$password = $_POST['password'];
	$password = hash('sha512', $password);

	// Nos conectamos a la base de datos.
	try {
		$conexion = new PDO('mysql:host=localhost:3307;dbname=login_practica', 'root', '');
	} catch (PDOException $e) {
		echo "Error:" . $e->getMessage();
	}

	$statement = $conexion->prepare('SELECT * FROM usuarios WHERE usuario = :usuario AND pass = :password');
	$statement->execute(array(
			':usuario' => $usuario,
			':password' => $password
		));

	$resultado = $statement->fetch();
	if ($resultado !== false) { // Hay contenido.
		$_SESSION['usuario'] = $usuario;
		header('Location: index.php'); // Redirigimos al usuario.
	} else {
		$errores = '<li>Datos incorrectos</li>';
	}
}

require 'views/login.view.php'; // Siempre debemos cargar el contenido de las vistas.

?>