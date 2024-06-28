<?php
if($_SERVER['REQUEST_METHOD'] === 'POST') {
	include_once 'connection.php';
	$nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
	$apellidos = filter_input(INPUT_POST, 'apellidos', FILTER_SANITIZE_STRING);
	$direccion = filter_input(INPUT_POST, 'direccion', FILTER_SANITIZE_STRING);
	$ciudad = filter_input(INPUT_POST, 'ciudad', FILTER_SANITIZE_STRING);
	$provincia = filter_input(INPUT_POST, 'provincia', FILTER_SANITIZE_STRING);
	$pais = filter_input(INPUT_POST, 'pais', FILTER_SANITIZE_STRING);
	$correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
	$contraseña = password_hash(filter_input(INPUT_POST, 'contraseña', FILTER_SANITIZE_SPECIAL_CHARS), PASSWORD_DEFAULT);
	try {
		$sqlInsert = $db->prepare('INSERT INTO usuarios (id, nombre, apellidos, direccion, ciudad, provincia, pais, correo, password) VALUES (NULL, :nombre, :apellidos, :direccion, :ciudad, :provincia, :pais, :correo, :password);');
		$sqlInsert->bindParam(':nombre', $nombre, PDO::PARAM_STR);
		$sqlInsert->bindParam(':apellidos', $apellidos, PDO::PARAM_STR);
		$sqlInsert->bindParam(':direccion', $direccion, PDO::PARAM_STR);
		$sqlInsert->bindParam(':ciudad', $ciudad, PDO::PARAM_STR);
		$sqlInsert->bindParam(':provincia', $provincia, PDO::PARAM_STR);
		$sqlInsert->bindParam(':pais', $pais, PDO::PARAM_STR);
		$sqlInsert->bindParam(':correo', $correo, PDO::PARAM_STR);
		$sqlInsert->bindParam(':password', $contraseña, PDO::PARAM_STR);
		$sqlInsert->execute();
	} catch(PDOException $e) {
		echo 'Error: ' . $e->getMessage();
	}
	$db = null;
}
header('location: usuarios.php');
exit;
?>