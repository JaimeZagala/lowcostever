<?php
session_start();
if(isset($_SESSION['id'])) {
	include_once 'connection.php';
	try {
		$usuario = htmlspecialchars($_SESSION['id']);
		$sqlSelectCarrito = $db->prepare('SELECT * FROM carrito WHERE usuarios_id = :usuarios_id;');
		$sqlSelectCarrito->bindParam(':usuarios_id', $usuario, PDO::PARAM_INT);
		$sqlSelectCarrito->execute();
		$result = $sqlSelectCarrito->fetchAll(PDO::FETCH_ASSOC);
	} catch(PDOException $e) {
		echo 'Error: ' . $e->getMessage();
		exit;
	}
	$tamaño = 0;
	foreach($result as $producto) {
		$tamaño += $producto['cantidad'];
	}
}
?>
<!doctype html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>LowCostEver</title>
	<link rel="stylesheet" href="styles/style.scss">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<header class="sticky-top user-select-none">
	<nav class="navbar navbar-expand-md bg-body-tertiary">
		<div class="container-fluid">
			<a class="navbar-brand" href="index.php">LowCostEver</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav me-auto mb-2 mb-lg-0">
					<?php if(isset($_SESSION['usuario'])): ?>
					<?php if($_SESSION['rol'] !== 3): ?>
					<li class="nav-item">
						<a class="nav-link" href="usuarios.php">Lista de usuarios</a>
					</li>
					<?php endif; ?>
					<li class="nav-item">
						<a class="nav-link" href="productos.php">Lista de productos</a>
					</li>
					<?php if($_SESSION['rol'] !== 3): ?>
					<li class="nav-item">
						<a class="nav-link" href="tickets.php">Lista de tickets</a>
					</li>
					<?php endif; ?>
					<?php endif; ?>
				</ul>
				<ul class="navbar-nav">
					<?php if(!isset($_SESSION['usuario'])): ?>
					<li class="nav-item">
						<a class="nav-link" href="login.php">Login</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="registro.php">Registro</a>
					</li>
					<?php else: ?>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-expanded="false">
							Bienvenid@, <?php echo $_SESSION['usuario']; ?>
						</a>
						<ul class="dropdown-menu">
							<li><a class="dropdown-item" href="dashboard.php">Mi perfil</a></li>
							<li>
								<a class="dropdown-item" href="carrito.php">
									Mi carrito
									<?php if($tamaño > 0): ?>
										<span class="badge text-bg-success"><?= htmlspecialchars($tamaño); ?></span>
									<?php endif; ?>
								</a>
							</li>
							<li><hr class="dropdown-divider"></li>
							<li><a class="dropdown-item" href="logout.php">Salir</a></li>
						</ul>
					</li>
				</ul>
				<?php endif; ?>
			</div>
		</div>
	</nav>
</header>