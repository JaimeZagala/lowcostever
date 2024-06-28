<?php
if($_SERVER['REQUEST_METHOD'] === 'GET') {
	include_once 'connection.php';
	$producto = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
	try {
		$sqlSelect = $db->prepare('SELECT * FROM productos_imagenes WHERE productos_id = :productos_id;');
		$sqlSelect->bindParam(':productos_id', $producto, PDO::PARAM_INT);
		$sqlSelect->execute();
		$result = $sqlSelect->fetchAll(PDO::FETCH_ASSOC);
	} catch(PDOException $e) {
		echo 'Error: ' . $e->getMessage();
		exit;
	}
	$db = null;
}
header('Content-Type: application/json');
echo json_encode($result);
?>