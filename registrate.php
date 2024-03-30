<!-- Este archivo es muy importante ya que se va a encargar de toda la lógica del registro, es decir, todas las validaciones. -->
<?php session_start();

// Comprobamos si ya tenemos una sesión.
// Si ya tiene una sesión redirigimos con header location al contenido, a través del index.php que nos lleva al contenido, para que no pueda volver a registrar un usuario el usuario que ya se haya logueado.
if (isset($_SESSION['usuario'])) {
	header('Location: index.php');
	die();
}

// Comprobamos si ya han sido enviado los datos.
if($_SERVER['REQUEST_METHOD'] == 'POST') { // Entonces significa que los datos sí fueron enviados.
	// Recibimos y validamos los datos que hayan sido rellenados.
	// Todos estos datos los estamos pasando por el name del input de registrate.view.php
	// Estamos auto-recibiendo los datos que estamos completando.
	$usuario = filter_var(strtolower($_POST['usuario']), FILTER_SANITIZE_STRING); // Transformamos el valor a través del método strtolower para almacenarlo en minúscula en la bdd. También limpiamos los valores con filter_var. También introducimos el parámetro FILTER_SANITIZE_STRING para evitar inyección de código.
	$password = $_POST['password'];
	$password2 = $_POST['password2'];

// También podemos limpiar mediante las funciones.
// El problema es que si lo hacemos de esta forma no estamos eliminando caracteres especiales, solo los transformamos.
	
// 	// La función htmlspecialchars() convierte caracteres especiales en entidades HTML, (&, "", '', <, >).
// 	$usuario = htmlspecialchars($_POST['usuario']);
// 	// La función trim() elimina espacios en blanco al inicio y final de la cadena de texto.
// 	$usuario = trim($usuario);
// 	// stripslashes() quita las barras de un string con comillas escapadas, los \ los convierte en \'
// 	$usuario = stripslashes($usuario);

	$errores = ''; // Para guardar los posibles errores que tengamos.

	// Comprobamos que ninguno de los campos este vacío.
	if (empty($usuario) or empty($password) or empty($password2)) {
		$errores = '<li>Por favor, rellena todos los datos correctamente</li>';
	} else {

		// Comprobamos que el usuario no exista ya.
		try {
			$conexion = new PDO('mysql:host=localhost:3307;dbname=login_practica', 'root', '');
		} catch (PDOException $e) {
			echo "Error:" . $e->getMessage(); // Objeto $e con el método getMessage()
		}

		$statement = $conexion->prepare('SELECT * FROM usuarios WHERE usuario = :usuario LIMIT 1'); // :usuario es un placeholder y por seguridad añadimos LIMIT 1 para que solo nos traiga un registro.
		// Es decir, le decimos que nos traiga todos los usuarios de la tabla que sean iguales al usuario que le pasemos en el placeholder de usuario.
		$statement->execute(array(':usuario' => $usuario)); // Ejecutamos nuestra consulta, importante que nuestro valor usuario sea la variable $usuario que hemos tratado más arriba.

		// El metodo fetch nos va a devolver el resultado (un array con los datos del usuario (id, nombre, pass)) o false en caso de que no haya resultado.
		$resultado = $statement->fetch(); // La variable $resultado va a guardar una de dos, o el registro del usuario que está repetido o false, si devuelve false significa que el usuario no existe y que debemos registrarlo.

		// Si resultado es diferente a false entonces significa que ya existe el usuario.
		if ($resultado != false) {
			$errores .= '<li>El nombre de usuario ya existe</li>';
		}

		// Hasheamos nuestra contraseña para protegerla un poco.
		// OJO: La seguridad es un tema muy complejo, aquí solo estamos haciendo un hash de la contraseña, pero esto no asegura por completo la información encriptada.
		$password = hash('sha512', $password); // sha512 es un algoritmo de encriptación.
		$password2 = hash('sha512', $password2);

		// Comprobamos que las contraseñas sean iguales.
		if ($password != $password2) {
			$errores.= '<li>Las contraseñas no son iguales</li>';
		}
	}

	// Comprobamos si hay errores, sino entonces agregamos el usuario y redirigimos.
	if ($errores == '') { // == porque es una comparación, si fuera = estaría asignando.
		$statement = $conexion->prepare('INSERT INTO usuarios (id, usuario, pass) VALUES (null, :usuario, :pass)');
		$statement->execute(array(
				':usuario' => $usuario, // Reemplazamos los placeholders de la sentencia sql.
				':pass' => $password
			));

		// Después de registrar al usuario redirigimos para que inicie sesión.
		header('Location: login.php');
	}

}

require 'views/registrate.view.php'; // Llamamos al formulario.
?>