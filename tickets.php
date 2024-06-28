<?php
include_once 'header.php';
if(!isset($_SESSION['usuario'])) {
	header('location: login.php');
	exit;
}
include_once 'connection.php';
$sqlSelect = $db->prepare('SELECT tickets.id, tickets.usuarios_id, tickets.precio_final, tickets.fecha, CONCAT(usuarios.nombre, " ", usuarios.apellidos) AS usuario FROM tickets JOIN usuarios ON usuarios.id = tickets.usuarios_id;');
$sqlSelect->execute();
$result = $sqlSelect->fetchAll();
$db = null;
?>
<div class="container text-center col-md-6 my-5">
	<img class="mx-auto my-4" src="images/lowcost.png" alt="" width="25%">
</div>
<div class="container text-center">
	<h3>Lista de tickets</h3>
</div>
<div class="container col-12 mt-5">
	<div class="row">
		<div class="col-md-12 d-flex justify-content-center">
			<table class="table table-striped">
				<thead>
					<tr>
						<th scope="col" class="col-1">Ticket</th>
						<th scope="col" class="col-2">Usuario</th>
						<th scope="col" class="col-2">Precio</th>
						<th scope="col" class="col-2">Fecha</th>
						<th scope="col" class="col-1"></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($result as $row): ?>
					<tr>
						<th scope="row"><?= $row['id']; ?></th>
						<td><?= $row['usuario']; ?></td>
						<td><?= $row['precio_final']; ?> €</td>
						<td><?= $row['fecha']; ?></td>
						<td><button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
							Button with data-bs-target
						</button></td>
						<div class="collapse" id="collapseExample">
							<div class="card card-body">
								Some placeholder content for the collapse component. This panel is hidden by default but revealed when the user activates the relevant trigger.
							</div>
						</div>
					</tr>
					<?php endforeach; ?>
				</tbody>
				<?php if($_SESSION['rol'] === 1): ?>
				<tfoot>
					<tr>
						<td colspan="7" class="text-center">
							<button class="btn btn-outline-success" onclick="añadirTicket()">Añadir nuevo ticket</button>
						</td>
					</tr>
				</tfoot>
				<?php endif; ?>
			</table>
		</div>
	</div>
	<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<form id="addForm" action="añadirticket.php" method="post">
					<div class="modal-header d-flex justify-content-between">
						<h5 class="modal-title" id="addModalLabel">Añadir producto</h5>
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
					</div>
					<div class="modal-body">
						<input type="number" id="addId" name="id" hidden>
						<div class="form-floating">
							<input name="producto" type="text" class="form-control" id="addProducto" placeholder="">
							<label for="addProducto">Producto</label>
						</div>
						<div class="form-floating">
							<textarea name="descripcion" type="text" class="form-control" rows="3" style="min-height: 100px;"  id="addDescripcion" placeholder=""></textarea>
							<label for="addDescripcion">Descripción</label>
						</div>
						<div class="form-floating">
							<input name="precio" type="text" class="form-control" id="addPrecio" placeholder="">
							<label for="addPrecio">Precio</label>
						</div>
						<div class="form-floating">
							<input name="cantidad" type="text" class="form-control" id="addCantidad" placeholder="">
							<label for="addCantidad">Cantidad</label>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-success">Añadir producto</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<form id="editForm" action="editarticket.php" method="post">
					<div class="modal-header d-flex justify-content-between">
						<h5 class="modal-title" id="editModalLabel">Editar producto</h5>
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
					</div>
					<div class="modal-body">
						<input type="number" id="editId" name="id" hidden>
						<div class="form-floating">
							<input name="producto" type="text" class="form-control" id="editProducto" placeholder="">
							<label for="inputProducto">Producto</label>
						</div>
						<div class="form-floating">
							<textarea name="descripcion" type="text" class="form-control" rows="3" style="min-height: 100px;"  id="editDescripcion" placeholder=""></textarea>
							<label for="inputDescripcion">Descripción</label>
						</div>
						<div class="form-floating">
							<input name="precio" type="text" class="form-control" id="editPrecio" placeholder="">
							<label for="inputPrecio">Precio</label>
						</div>
						<div class="form-floating">
							<input name="cantidad" type="text" class="form-control" id="editCantidad" placeholder="">
							<label for="inputCantidad">Cantidad</label>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-primary">Guardar cambios</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<form id="deleteForm" action="borrarproducto.php" method="post">
					<div class="modal-header d-flex justify-content-between">
						<h5 class="modal-title" id="deleteModalLabel">Borrar producto</h5>
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
					</div>
					<div class="modal-body">
						<input type="number" id="deleteId" name="id" hidden>
						<h6>Estás a punto de borrar el producto <span id="deleteProduct"></span>. Esta acción no se puede deshacer.</h6>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-danger">Borrar producto</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
	function añadirTicket() {
		const modal = new bootstrap.Modal(document.querySelector('#addModal'));
		modal.show();
	}

	function editarTicket(id, producto, descripcion, precio, cantidad) {
		document.querySelector('#editId').value = id;
		document.querySelector('#editProducto').value = producto;
		document.querySelector('#editDescripcion').value = descripcion;
		document.querySelector('#editPrecio').value = precio;
		document.querySelector('#editCantidad').value = cantidad;
		const modal = new bootstrap.Modal(document.querySelector('#editModal'));
		modal.show();
	}
	
	function borrarProducto(id, producto) {
		document.querySelector('#deleteId').value = id;
		document.querySelector('#deleteProduct').textContent = producto;
		const modal = new bootstrap.Modal(document.querySelector('#deleteModal'));
		modal.show();
	}
</script>
<?php include_once 'footer.php'; ?>