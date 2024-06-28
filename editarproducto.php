<?php
session_start();
if($_SESSION['rol'] === 1 and $_SERVER['REQUEST_METHOD'] === 'POST') {
	include_once 'connection.php';
	$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
	$producto = filter_input(INPUT_POST, 'producto', FILTER_SANITIZE_SPECIAL_CHARS);
	$descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_SPECIAL_CHARS);
	$precio = filter_input(INPUT_POST, 'precio', FILTER_VALIDATE_FLOAT);
	$unidades = filter_input(INPUT_POST, 'unidades', FILTER_VALIDATE_INT);
	try {
		$sqlUpdateProducto = $db->prepare('UPDATE productos SET producto = :producto, descripcion = :descripcion, precio = :precio, unidades = :unidades WHERE id = :id;');
		$sqlUpdateProducto->bindParam(':producto', $producto, PDO::PARAM_STR);
		$sqlUpdateProducto->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
		$sqlUpdateProducto->bindParam(':precio', $precio, PDO::PARAM_STR);
		$sqlUpdateProducto->bindParam(':unidades', $unidades, PDO::PARAM_INT);
		$sqlUpdateProducto->bindParam(':id', $id, PDO::PARAM_INT);
		$sqlUpdateProducto->execute();
	} catch(PDOException $e) {
		echo 'Error: ' . $e->getMessage();
		exit;
	}

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
// header('location: productos.php');
// exit;
?>