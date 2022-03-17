<?php
$conexion = mysqli_connect("localhost","root","","db_prueba");
if (!$conexion) {
	echo 'Error al conectar a la base de datos';
} else {
	echo 'Conectando a la base de datos.';
}
?>