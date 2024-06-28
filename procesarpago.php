<?php
session_start();
if($_SERVER['REQUEST_METHOD'] === 'POST') {
	include_once 'connection.php';
	$usuario = htmlspecialchars($_SESSION['id']);
	try {
		$sqlSelectCarrito = $db->prepare('SELECT carrito.usuarios_id, carrito.cantidad, carrito.productos_id, productos.precio, productos.unidades FROM carrito JOIN productos ON productos.id = carrito.productos_id WHERE usuarios_id = :usuarios_id;');
		$sqlSelectCarrito->bindParam(':usuarios_id', $usuario, PDO::PARAM_INT);
		$sqlSelectCarrito->execute();
		$resultCarrito = $sqlSelectCarrito->fetchAll(PDO::FETCH_ASSOC);
	} catch(PDOException $e) {
		echo 'Error: ' . $e->getMessage();
		exit;
	}

	try {
		$precioFinal = 0;
		foreach($resultCarrito as $producto) $precioFinal += $producto['cantidad'] * $producto['precio'];
		$sqlInsertTicket = $db->prepare('INSERT INTO tickets (usuarios_id, precio_final) VALUES (:usuarios_id, :precio_final);');
		$sqlInsertTicket->bindParam(':usuarios_id', $producto['usuarios_id'], PDO::PARAM_INT);
		$sqlInsertTicket->bindParam(':precio_final', $precioFinal, PDO::PARAM_STR);
		$sqlInsertTicket->execute();
	} catch(PDOException $e) {
		echo 'Error: ' . $e->getMessage();
		exit;
	}

	$ticketId = $db->lastInsertId();
	echo 'Ticket ID: ' . $ticketId . '<br>';
	foreach($resultCarrito as $producto) {
		try {
			$sqlInsertLinea = $db->prepare('INSERT INTO productos_ticket (tickets_id, productos_id, precio, cantidad) VALUES (:tickets_id, :productos_id, :precio, :cantidad);');
			$sqlInsertLinea->bindParam(':tickets_id', $ticketId, PDO::PARAM_INT);
			$sqlInsertLinea->bindParam(':productos_id', $producto['productos_id'], PDO::PARAM_INT);
			$sqlInsertLinea->bindParam(':precio', $producto['precio'], PDO::PARAM_STR);
			$sqlInsertLinea->bindParam(':cantidad', $producto['cantidad'], PDO::PARAM_INT);
			$sqlInsertLinea->execute();
		} catch(PDOException $e) {
			echo 'Error: ' . $e->getMessage();
			exit;
		}
		echo 'He insertado una línea al ticket<br>';
	}

	try {
		$sqlDeleteCarrito = $db->prepare('DELETE FROM carrito WHERE usuarios_id = :usuarios_id;');
		$sqlDeleteCarrito->bindParam(':usuarios_id', $usuario, PDO::PARAM_INT);
		$sqlDeleteCarrito->execute();
	} catch(PDOException $e) {
		echo 'Error: ' . $e->getMessage();
		exit;
	}
}
header('location: carrito.php');
exit;
?>