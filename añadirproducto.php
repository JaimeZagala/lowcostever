<?php
session_start();
if($_SESSION['rol'] === 1 and $_SERVER['REQUEST_METHOD'] === 'POST') {
	include_once 'connection.php';
	$producto = filter_input(INPUT_POST, 'producto', FILTER_SANITIZE_SPECIAL_CHARS);
	$descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_SPECIAL_CHARS);
	$precio = filter_input(INPUT_POST, 'precio', FILTER_VALIDATE_FLOAT);
	$unidades = filter_input(INPUT_POST, 'unidades', FILTER_VALIDATE_INT);
	try {
		$sqlInsertProducto = $db->prepare('INSERT INTO productos (producto, descripcion, precio, unidades) VALUES (:producto, :descripcion, :precio, :unidades);');
		$sqlInsertProducto->bindParam(':producto', $producto, PDO::PARAM_STR);
		$sqlInsertProducto->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
		$sqlInsertProducto->bindParam(':precio', $precio, PDO::PARAM_STR);
		$sqlInsertProducto->bindParam(':unidades', $unidades, PDO::PARAM_INT);
		$sqlInsertProducto->execute();
	} catch(PDOException $e) {
		echo 'Error: ' . $e->getMessage();
		exit;
	}

	$id = $db->lastInsertId();
	$uploadsDir = 'uploads/';
	if(!is_dir($uploadsDir)) mkdir($uploadsDir, 0777, true);
	foreach($_FILES['imagen']['tmp_name'] as $key => $tmp_name) {
		$fileName = basename($_FILES['imagen']['name'][$key]);
		$ruta = $uploadsDir . $fileName;
		$alt = pathinfo($fileName, PATHINFO_FILENAME);
		if(move_uploaded_file($tmp_name, $ruta)) {
			try {
				$sqlInsertImagen = $db->prepare('INSERT INTO productos_imagenes (productos_id, ruta, alt) VALUES (:productos_id, :ruta, :alt);');
				$sqlInsertImagen->bindParam(':productos_id', $id, PDO::PARAM_INT);
				$sqlInsertImagen->bindParam(':ruta', $ruta, PDO::PARAM_STR);
				$sqlInsertImagen->bindParam(':alt', $alt, PDO::PARAM_STR);
				$sqlInsertImagen->execute();
			} catch(PDOException $e) {
				echo 'Error: ' . $e->getMessage();
				exit;
			}
		}
	}
}
header('location: productos.php');
exit;
?>