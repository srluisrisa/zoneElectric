<?php
	include 'cn.php';

	$nombres = $_POST['nombres'];
	$apellido_p = $_POST['apellido_p'];
	$apellido_m = $_POST['apellido_m'];
	$usuario = $_POST['usuario'];
	$email = $_POST['email'];
	$password = $_POST['password'];

	$insertar = "INSERT INTO usuarios(nombres, apellido_p, apellido_m, usuario, email, password) 
	VALUES ('$nombres','$apellido_p','$apellido_m','$usuario','$email','$password')";

	$resultado = mysqli_query($conexion, $insertar);
	if (!$resultado) {
		echo 'Error al registrarse';
	} else { 
		 echo' Usuario registrado exitosamente';
	}

	mysqli_close($conexion);
?>