<?php
if($_SERVER['REQUEST_METHOD'] === 'POST') {
	include_once 'connection.php';
	$producto = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
	try {
		$sqlDelete = $db->prepare('DELETE FROM productos WHERE id = :id;
		DELETE FROM productos_imagenes WHERE productos_id = :id;');
		$sqlDelete->bindParam(':id', $producto, PDO::PARAM_INT);
		$sqlDelete->execute();
	} catch(PDOException $e) {
		echo 'Error: ' . $e->getMessage();
	}
	$db = null;
}
header('location: productos.php');
exit;
?>