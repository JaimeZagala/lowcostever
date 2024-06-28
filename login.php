<?php
include_once 'header.php';
if(isset($_SESSION['usuario'])) {
	header('location: dashboard.php');
	exit;
}
include_once 'connection.php';
if($_SERVER['REQUEST_METHOD'] === 'POST') {
	$correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
	$contraseña = filter_input(INPUT_POST, 'contraseña', FILTER_SANITIZE_SPECIAL_CHARS);

	try {
		$sqlLogin = $db->prepare('SELECT * FROM usuarios WHERE correo = ?;');
		$sqlLogin->execute(array($correo));
		$resultado = $sqlLogin->fetch(PDO::FETCH_ASSOC);
		var_dump($resultado);
		if($resultado) {
			if(password_verify($contraseña, $resultado['password'])) {
				$_SESSION['id'] = $resultado['id'];
				$_SESSION['usuario'] = $resultado['nombre'];
				$_SESSION['rol'] = $resultado['rol'];
				header('location: dashboard.php');
				exit;
			} else {
				$mensajeError = 'Credenciales incorrectas';
			}
		} else {
			$mensajeError = 'El usuario no existe';
		}
	} catch (PDOException $e) {
		echo "Error al insertar datos: " . $e->getMessage();
	}
}
$db = null;
?>
<div class="container col text-center col-md-6 my-5">
	<img class="mx-auto my-4" src="images/lowcost.png" alt="" width="25%">
</div>
<div class="container col-md-6 my-4 text-center">
	<form action="login.php" method="post">
		<h1 class="h3 mb-3 fw-normal">Iniciar sesión</h1>
		<?php if(isset($mensajeError)): ?>
			<div class="alert alert-warning">
				<?php echo htmlspecialchars($mensajeError); ?>
			</div>
		<?php endif; ?>
		<div class="form-floating">
			<input name="correo" type="email" class="form-control" id="floatingCorreo" placeholder="Correo">
			<label for="floatingCorreo">Correo</label>
		</div>
		<div class="form-floating">
			<input name="contraseña" type="password" class="form-control" id="floatingContraseña" placeholder="Contraseña">
			<label for="floatingContraseña">Contraseña</label>
		</div>
		<div class="form-check text-start my-3">
			<input name="remember" class="form-check-input" type="checkbox" id="flexCheckDefault">
			<label class="form-check-label" for="flexCheckDefault">
				Recordarme
			</label>
		</div>
		<button class="btn btn-primary w-100 py-2" type="submit">Iniciar sesión</button>
	</form>
</div>
<?php include_once 'footer.php'; ?>