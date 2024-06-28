<?php
include_once 'header.php';
if(!isset($_SESSION['usuario'])) {
	header('location: login.php');
	exit;
}
include_once 'connection.php';
try {
	$sqlSelectProductos = $db->prepare('SELECT * FROM productos;');
	$sqlSelectProductos->execute();
	$result = $sqlSelectProductos->fetchAll();
} catch(PDOException $e) {
	echo 'Error: ' . $e->getMessage();
	exit;
}
if($_SERVER['REQUEST_METHOD'] === 'POST') {
	$usuario = htmlspecialchars($_SESSION['id']);
	$producto = filter_input(INPUT_POST, 'producto', FILTER_VALIDATE_INT);
	$cantidad = filter_input(INPUT_POST, 'cantidad', FILTER_VALIDATE_INT);
	if($cantidad > 0) {
		try {
			$sqlInsert = $db->prepare('INSERT INTO carrito (usuarios_id, productos_id, cantidad) VALUES (:usuarios_id, :productos_id, :cantidad) ON DUPLICATE KEY UPDATE cantidad = cantidad + :cantidad;');
			$sqlInsert->bindParam(':usuarios_id', $usuario, PDO::PARAM_INT);
			$sqlInsert->bindParam(':productos_id', $producto, PDO::PARAM_INT);
			$sqlInsert->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
			$sqlInsert->execute();
		} catch(PDOException $e) {
			echo 'Error: ' . $e->getMessage();
			exit;
		}
	}
	header('location: productos.php');
	exit;
}
$db = null;
?>
<div class="container text-center col-md-6 my-5">
	<img class="mx-auto my-4" src="images/lowcost.png" alt="" width="25%">
</div>
<div class="container text-center">
	<h3>Lista de productos</h3>
</div>
<div class="container row gap-3" id="lista-productos"></div>
<div class="container col-12 mt-5">
	<div class="row">
		<div class="col-md-12 d-flex justify-content-center">
			<table class="table table-striped" id="tabla-productos">
				<thead>
					<tr>
						<th scope="col" class="col-1">Producto</th>
						<th scope="col" class="col-7">Descripción</th>
						<th scope="col" class="col-1 text-center">Precio</th>
						<th scope="col" class="col-1 text-center">Unidades</th>
						<?php if($_SESSION['rol'] === 1): ?>
							<th scope="col" class="col-1 text-center">Editar</th>
							<th scope="col" class="col-1 text-center">Borrar</th>
						<?php else: ?>
							<th scope="col" class="col-1 text-center"></th>
						<?php endif; ?>
					</tr>
				</thead>
				<tbody>
					<?php foreach($result as $row): ?>
						<tr>
							<th scope="row"><?= $row['producto']; ?></th>
							<td><?= $row['descripcion']; ?></td>
							<td class="text-center"><?= $row['precio']; ?>€/ud.</td>
							<td class="text-center"><?= $row['unidades']; ?> uds.</td>
							<?php if($_SESSION['rol'] === 1): ?>
							<td class="text-center"><button class="btn btn-primary btn-edit" onclick="editarProducto('<?= $row['id']; ?>','<?= $row['producto']; ?>','<?= $row['descripcion']; ?>','<?= $row['precio']; ?>','<?= $row['unidades']; ?>')"><i class="bi bi-pencil-square"></i></button></td>
							<td class="text-center"><button class="btn btn-danger btn-delete" onclick="borrarProducto('<?= $row['id']; ?>','<?= $row['producto']; ?>')"><i class="bi bi-trash"></i></button></td>
							<?php endif; ?>
							<?php if($_SESSION['rol'] !== 1): ?>
							<td>
								<form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
									<input hidden name="producto" value="<?= $row['id']; ?>"></input>
									<select class="w-100 form-select" name="cantidad" onchange="cambiarUnidades(<?= $row['id']; ?>, this.value)">
										<?php for($i = 0; $i <= $row['unidades']; $i++): ?>
											<option value="<?= $i; ?>"><?= $i; ?></option>
										<?php endfor; ?>
									</select>
									<button class="w-100 mt-1 btn btn-warning disabled" id="boton-carrito-<?= $row['id']; ?>" type="submit"><i class="bi bi-cart-plus"></i></button>
								</form>
							</td>
							<?php endif; ?>
						</tr>
					<?php endforeach; ?>
				</tbody>
				<?php if($_SESSION['rol'] === 1): ?>
				<tfoot>
					<tr>
						<td colspan="7" class="text-center">
							<button class="btn btn-outline-success" onclick="añadirProducto()">Añadir nuevo producto</button>
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
				<form id="addForm" action="añadirproducto.php" method="post" enctype="multipart/form-data">
					<div class="modal-header d-flex justify-content-between">
						<h5 class="modal-title" id="addModalLabel">Añadir producto</h5>
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
					</div>
					<div class="modal-body">
						<div class="form-floating my-2">
							<input name="producto" type="text" class="form-control" id="addProducto" placeholder="" required>
							<label for="addProducto">Producto</label>
						</div>
						<div class="form-floating my-2">
							<textarea name="descripcion" type="text" class="form-control" rows="3" style="min-height: 100px;"  id="addDescripcion" placeholder="" required></textarea>
							<label for="addDescripcion">Descripción</label>
						</div>
						<div class="form-floating my-2">
							<input name="precio" type="text" class="form-control" id="addPrecio" placeholder="" required>
							<label for="addPrecio">Precio</label>
						</div>
						<div class="form-floating my-2">
							<input name="unidades" type="text" class="form-control" id="addUnidades" placeholder="" required>
							<label for="addUnidades">Unidades</label>
						</div>
						<div class="my-2">
							<input name="imagen[]" type="file" class="form-control" id="addImagen" multiple required>
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
				<form id="editForm" action="editarproducto.php" method="post">
					<div class="modal-header d-flex justify-content-between">
						<h5 class="modal-title" id="editModalLabel">Editar producto</h5>
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
					</div>
					<div class="modal-body">
						<input type="number" id="editId" name="id" hidden>
						<div class="form-floating my-2">
							<input name="producto" type="text" class="form-control" id="editProducto" placeholder="" required>
							<label for="editProducto">Producto</label>
						</div>
						<div class="form-floating my-2">
							<textarea name="descripcion" type="text" class="form-control" rows="3" style="min-height: 100px;"  id="editDescripcion" placeholder="" required></textarea>
							<label for="editDescripcion">Descripción</label>
						</div>
						<div class="form-floating my-2">
							<input name="precio" type="text" class="form-control" id="editPrecio" placeholder="" required>
							<label for="editPrecio">Precio</label>
						</div>
						<div class="form-floating my-2">
							<input name="unidades" type="text" class="form-control" id="editUnidades" placeholder="" required>
							<label for="editUnidades">Unidades</label>
						</div>
						<div class="accordion">
							<div class="accordion-item">
								<h2 class="accordion-header">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse" aria-expanded="false" aria-controls="collapse">
									Imágenes
								</button>
								</h2>
								<div id="collapse" class="accordion-collapse collapse" data-bs-parent="#accordion">
									<div class="accordion-body container" id="editImagen"></div>
								</div>
							</div>
						</div>
						<div class="my-2">
							<input name="imagen[]" type="file" class="form-control" id="editImagen" multiple>
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
						<h6>Estás a punto de borrar el producto <span id="deleteProducto"></span>. Esta acción no se puede deshacer.</h6>
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
	// document.addEventListener('DOMContentLoaded', () => {
	// 	const productos = document.querySelector('#lista-productos');
	// 	fetch('obtenerproductos.php')
	// 		.then(response => response.json())
	// 		.then(data => {
	// 			data.forEach(producto => {
	// 				const card = document.createElement('div');
	// 				card.className = 'card col-3';
	// 				// card.style = 'width: 18rem;';
	// 				const carousel = document.createElement('div');
	// 				carousel.id = 'carousel-' + producto.id;
	// 				carousel.className = 'card-img-top carousel slide';
	// 				const inner = document.createElement('div');
	// 				inner.className = 'carousel-inner';
	// 				let active = true;
	// 				fetch('obtenerimagenes.php?id=' + producto.id)
	// 					.then(response => response.json())
	// 					.then(data => {
	// 						data.forEach(imagen => {
	// 							const item = document.createElement('div');
	// 							item.className = 'carousel-item';
	// 							if(active) {
	// 								item.classList.add('active');
	// 								active = false;
	// 							}
	// 							const img = document.createElement('img');
	// 							img.className = 'd-block w-100';
	// 							img.src = imagen.ruta;
	// 							img.alt = imagen.alt;
	// 							item.appendChild(img);
	// 							inner.appendChild(item);
	// 						});
	// 					}).catch(error => console.log('Error al obtener las imágenes: ', error));
	// 				carousel.appendChild(inner);
	// 				card.appendChild(carousel);
	// 				const body = document.createElement('div');
	// 				body.className = 'card-body';
	// 				const productName = document.createElement('h5');
	// 				productName.textContent = producto.producto;
	// 				body.appendChild(productName);
	// 				const previousBtn = document.createElement('button');
	// 				previousBtn.className = 'carousel-control-prev';
	// 				previousBtn.type = 'button';
	// 				previousBtn.setAttribute('data-bs-target', '#carousel');
	// 				previousBtn.setAttribute('data-bs-slide', 'prev');
	// 				carousel.appendChild(previousBtn);
	// 				const nextBtn = document.createElement('button');
	// 				nextBtn.className = 'carousel-control-next';
	// 				nextBtn.type = 'button';
	// 				nextBtn.setAttribute('data-bs-target', '#carousel-' + producto.id);
	// 				nextBtn.setAttribute('data-bs-slide', 'next');
	// 				carousel.appendChild(nextBtn);
	// 				card.appendChild(body);
	// 				productos.appendChild(card);
	// 			});
	// 		}).catch(error => console.log('Error al obtener los productos: ', error));
	// });

	function añadirProducto() {
		const modal = new bootstrap.Modal(document.querySelector('#addModal'));
		modal.show();
	}

	function editarProducto(id, producto, descripcion, precio, unidades) {
		document.querySelector('#editId').value = id;
		document.querySelector('#editProducto').value = producto;
		document.querySelector('#editDescripcion').value = descripcion;
		document.querySelector('#editPrecio').value = precio;
		document.querySelector('#editUnidades').value = unidades;
		const editImagen = document.querySelector('#editImagen');
		editImagen.innerHTML = '';
		fetch('obtenerimagenes.php?id=' + id)
			.then(response => response.json())
			.then(data => {
				data.forEach(imagen => {
					if(imagen.productos_id = id) {
						const div = document.createElement('div');
						div.className = 'col position-relative w-100';
						const img = document.createElement('img');
						img.src = imagen.ruta;
						img.alt = imagen.alt;
						img.className = 'img-thumbnail';
						div.appendChild(img);
						const form = document.createElement('form');
						form.action = 'borrarimagen.php?img=' + imagen.ruta;
						form.method = 'post';
						const borrar = document.createElement('button');
						borrar.name = 'imagen';
						borrar.innerHTML = 'X';
						borrar.className = 'position-absolute top-0 end-0 badge btn btn-sm btn-danger';
						borrar.type = 'submit';
						form.appendChild(borrar);
						div.appendChild(form);
						editImagen.appendChild(div);
					}
				});
			}).catch(error => console.log('Error al obtener imagenes: ', error));
		const modal = new bootstrap.Modal(document.querySelector('#editModal'));
		modal.show();
	}

	function borrarImagen(id) {
		
	}
	
	function borrarProducto(id, producto) {
		document.querySelector('#deleteId').value = id;
		document.querySelector('#deleteProducto').textContent = producto;
		const modal = new bootstrap.Modal(document.querySelector('#deleteModal'));
		modal.show();
	}

	function cambiarUnidades(id, unidades) {
		const botonAñadirCarrito = document.querySelector('#boton-carrito-' + id);
		unidades === 0
			? botonAñadirCarrito.classList.add('disabled')
			: botonAñadirCarrito.classList.remove('disabled');
	}
</script>
<?php include_once 'footer.php'; ?>