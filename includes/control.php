<?php
include("conexion.php");

$usuario = $_POST["usuario"];
$password =$_POST["clave"];

$myclave = mysqli_query($mysqli, "SELECT * FROM usuarios WHERE usuario = '".htmlentities($usuario)."' and password= '".htmlentities($password)."' LIMIT 1"); 
$nmyclave = mysqli_num_rows($myclave); 
$fila = mysqli_fetch_array($myclave);
	
if($nmyclave != 0){ 
	session_start(); 
	$_SESSION["usuario"] = $fila['usuario']; 
	$msg["status"] = true;
	$msg["continue"] = "main.php";
	echo json_encode($msg);
	mysqli_close($mysqli);
	exit();
}else{ 
	$msg["status"] = false;
	$msg["message"] = "El usuario o la contraseña no son correctos, verifique su información.";
	echo json_encode($msg);
	mysqli_close($mysqli);
	exit();
}
?>

