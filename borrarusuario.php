<?php
if($_SERVER['REQUEST_METHOD'] === 'POST') {
	include_once 'connection.php';
	try {
		$sqlDelete = $db->prepare('DELETE FROM usuarios WHERE id = :id;');
		$sqlDelete->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
		$sqlDelete->execute();
	} catch(PDOException $e) {
		echo 'Error: ' . $e->getMessage();
	}
	$db = null;
}
header('location: usuarios.php');
exit;
?>