<?php
include_once 'header.php';
if(!isset($_SESSION['usuario'])) {
	header('location: login.php');
	exit;
}
include_once 'connection.php';
if($_SERVER['REQUEST_METHOD'] === 'POST') {
	$producto = filter_input(INPUT_POST, 'producto', FILTER_VALIDATE_INT);
	$cantidad = filter_input(INPUT_POST, 'cantidad', FILTER_VALIDATE_INT);
	$total = filter_input(INPUT_POST, 'total', FILTER_VALIDATE_INT);
	if($cantidad != 0) {
		if($cantidad == $total) {
			try {
				$sqlDelete = $db->prepare('DELETE FROM carrito WHERE productos_id = :productos_id;');
				$sqlDelete->bindParam(':productos_id', $producto, PDO::PARAM_INT);
				$sqlDelete->execute();
			} catch(PDOException $e) {
				echo 'Error: ' . $e->getMessage();
				exit;
			}
		} else {
			try {
				$sqlUpdate = $db->prepare('UPDATE carrito SET cantidad = cantidad - :cantidad WHERE productos_id = :productos_id');
				$sqlUpdate->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
				$sqlUpdate->bindParam(':productos_id', $producto, PDO::PARAM_INT);
				$sqlUpdate->execute();
			} catch(PDOException $e) {
				echo 'Error: ' . $e->getMessage();
				exit;
			}
		}
	}
	header('location: carrito.php');
	exit;
}
try {
	$usuario = htmlspecialchars($_SESSION['id']);
	$sqlSelect = $db->prepare('SELECT * FROM carrito JOIN productos ON productos.id = carrito.productos_id WHERE carrito.usuarios_id = :usuarios_id;');
	$sqlSelect->bindParam(':usuarios_id', $usuario, PDO::PARAM_INT);
	$sqlSelect->execute();
	$result = $sqlSelect->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
	echo 'Error: ' . $e->getMessage();
	exit;
}
$db = null;
$precioCarrito = 0;
?>
<div class="container text-center col-md-6 my-5">
	<img class="mx-auto my-4" src="images/lowcost.png" alt="" width="25%">
</div>
<div class="container text-center">
	<h3>Cesta de la compra</h3>
</div>
<div class="container">
	<?php if(!$result): ?>
		<h2 class="text-center">La cesta está vacía</h2>
	<?php else: ?>
	<table class="table table-striped">
		<thead>
			<tr>
				<th scope="col" class="col-2">Producto</th>
				<th scope="col" class="col-7">Descripción</th>
				<th scope="col" class="col-1 text-center">Precio</th>
				<th scope="col" class="col-1 text-center">Cantidad</th>
				<th scope="col" class="col-1 text-center"></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($result as $row): ?>
			<tr>
				<th scope="row"><?= $row['producto']; ?></th>
				<td><?= $row['descripcion']; ?></td>
				<td class="text-center"><?= $row['precio']; ?> €/ud.</td>
				<td class="text-center"><?= $row['cantidad']; ?> uds.</td>
				<td>
					<form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
						<input hidden name="producto" value="<?= $row['id']; ?>"></input>
						<input hidden name="total" value="<?= $row['cantidad']; ?>"></input>
						<select class="w-100 form-select" name="cantidad" onchange="cambiarCantidad(<?= $row['id']; ?>, this.value)">
							<?php for($i = 0; $i <= $row['cantidad']; $i++): ?>
								<option value="<?= $i; ?>"><?= $i; ?></option>
							<?php endfor; ?>
						</select>
						<button class="w-100 mt-1 btn btn-warning disabled" id="boton-carrito-<?= $row['id']; ?>" type="submit"><i class="bi bi-cart-dash"></i></button>
					</form>
				</td>
				<?php $precioCarrito += $row['precio'] * $row['cantidad']; ?>
			</tr>
			<?php endforeach; ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="2"></td>
				<th class="text-center">Total:</th>
				<td class="text-center"><?= number_format($precioCarrito, 2); ?>€</td>
				<td>
					<form action="procesarpago.php" method="post">
					<button class="w-100 btn btn-success"><i class="bi bi-cart-check"></i></button>
				</form>
				</td>
			</tr>
		</tfoot>
	</table>
	<?php endif; ?>
</div>
<script>
	function cambiarCantidad(id, cantidad) {
		const botonAñadirCarrito = document.querySelector('#boton-carrito-' + id);
		cantidad == 0
			? botonAñadirCarrito.classList.add('disabled')
			: botonAñadirCarrito.classList.remove('disabled');
	}
</script>
<?php include_once 'footer.php'; ?>