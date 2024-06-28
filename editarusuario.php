<?php
if($_SERVER['REQUEST_METHOD'] === 'POST') {
	include_once 'connection.php';
	try {
		$sqlUpdate = $db->prepare('UPDATE usuarios SET nombre = :nombre, apellidos = :apellidos, direccion = :direccion, ciudad = :ciudad, provincia = :provincia, pais = :pais, correo = :correo, rol = :rol WHERE id = :id;');
		$sqlUpdate->bindParam(':nombre', $_POST['nombre'], PDO::PARAM_STR);
		$sqlUpdate->bindParam(':apellidos', $_POST['apellidos'], PDO::PARAM_STR);
		$sqlUpdate->bindParam(':direccion', $_POST['direccion'], PDO::PARAM_STR);
		$sqlUpdate->bindParam(':ciudad', $_POST['ciudad'], PDO::PARAM_STR);
		$sqlUpdate->bindParam(':provincia', $_POST['provincia'], PDO::PARAM_STR);
		$sqlUpdate->bindParam(':pais', $_POST['pais'], PDO::PARAM_STR);
		$sqlUpdate->bindParam(':correo', $_POST['correo'], PDO::PARAM_STR);
		$sqlUpdate->bindParam(':rango', $_POST['rango'], PDO::PARAM_INT);
		$sqlUpdate->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
		$sqlUpdate->execute();
	} catch(PDOException $e) {
		echo 'Error: ' . $e->getMessage();
	}
	$db = null;
}
header('location: usuarios.php');
exit;
?>