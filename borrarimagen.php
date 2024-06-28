<?php
if($_SERVER['REQUEST_METHOD'] === 'POST') {
	include_once 'connection.php';
	$imagen = filter_input(INPUT_POST, 'imagen', FILTER_VALIDATE_INT);
	try {
		$sqlDelete = $db->prepare('DELETE FROM productos_imagenes WHERE ruta = :imagen;');
		$sqlDelete->bindParam(':imagen', $imagen, PDO::PARAM_INT);
		$sqlDelete->execute();
	} catch(PDOException $e) {
		echo 'Error: ' . $e->getMessage();
	}
	$db = null;
}
header('location: productos.php');
exit;
?>