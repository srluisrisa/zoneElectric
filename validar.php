<?php	
	$email=$_POST['email'];
	$password=$_POST['password'];
	session_start();
	$_SESSION['email']=$email;

	$conexion=mysqli_connect("localhost","root","","db_prueba");

	$consulta="SELECT*FROM usuarios where email='$email' and password='$password'";
	$resultado=mysqli_query($conexion, $consulta);

	$filas=mysqli_num_rows($resultado);

	if($filas){
		header("location:index2.php");
	} else {
		?>
		<?php 
		include("error2.php");
		?>
		<h1> ERROR EN LA AUTENTIFICACION</h1>
		<?php 
	}
mysqli_free_result($resultado);
mysqli_close($conexion);