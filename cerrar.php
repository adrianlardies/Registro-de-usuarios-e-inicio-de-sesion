<?php session_start();

session_destroy();
$_SESSION = array(); // Array vacio, de esta forma dejamos el valor de $_SESSION a 0, la limpiamos.

header('Location: login.php');
die(); // Matamos la página (es prescindible este dire()).

?>