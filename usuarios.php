<?php
include_once 'header.php';
if(!isset($_SESSION['usuario']) or $_SESSION['rol'] >= 3) {
	header('location: dashboard.php');
	exit;
}
include_once 'connection.php';
$sqlSelect = $db->prepare('SELECT * FROM usuarios;');
$sqlSelect->execute();
$result = $sqlSelect->fetchAll();
$db = null;
?>
<div class="container text-center col-md-6 my-5">
	<img class="mx-auto my-4" src="images/lowcost.png" alt="" width="25%">
</div>
<div class="container text-center">
	<h3>Lista de usuarios</h3>
</div>
<div class="container col-12 mt-5">
	<div class="row">
		<div class="col-md-12 d-flex justify-content-center">
			<table class="table table-striped">
				<thead>
					<tr>
						<th scope="col" class="col">Nombre</th>
						<th scope="col" class="col">Apellidos</th>
						<th scope="col" class="col">Correo</th>
						<?php if($_SESSION['rol'] <= 2): ?>
							<th scope="col" class="col"></th>
						<?php endif; ?>
						<?php if($_SESSION['rol'] === 1): ?>
							<th scope="col" class="col"></th>
							<th scope="col" class="col"></th>
						<?php endif; ?>
					</tr>
				</thead>
				<tbody>
					<?php foreach($result as $row): ?>
						<tr>
							<th scope="row"><?= $row['nombre']; ?></th>
							<th><?= $row['apellidos']; ?></th>
							<td><?= $row['correo']; ?></td>
							<?php if($_SESSION['rol'] <= 2): ?>
								<td>
									<button class="btn btn-info btn-details" onclick="mostrarUsuario('<?= $row['id']; ?>', '<?= $row['nombre']; ?>', '<?= $row['apellidos']; ?>', '<?= $row['direccion']; ?>', '<?= $row['ciudad']; ?>', '<?= $row['provincia']; ?>', '<?= $row['pais']; ?>', '<?= $row['correo']; ?>', '<?= $row['rol']; ?>')"><i class="bi bi-person-lines-fill"></i> Detalles</button>
								</td>
							<?php endif; ?>
							<?php if($_SESSION['rol'] === 1): ?>
								<td>
									<button class="btn btn-primary btn-edit" onclick="editarUsuario('<?= $row['id']; ?>','<?= $row['nombre']; ?>','<?= $row['apellidos']; ?>','<?= $row['direccion']; ?>','<?= $row['ciudad']; ?>','<?= $row['provincia']; ?>','<?= $row['pais']; ?>','<?= $row['correo']; ?>','<?= $row['rol']; ?>')"><i class="bi bi-pencil-square"></i> Editar</button>
								</td>
								<td>
									<button class="btn btn-danger btn-delete" onclick="borrarUsuario('<?= $row['id']; ?>','<?= $row['correo']; ?>')"><i class="bi bi-trash"></i> Borrar</button>
								</td>
							<?php endif; ?>
						</tr>
					<?php endforeach; ?>
				</tbody>
				<?php if($_SESSION['rol'] === 1): ?>
					<tfoot>
						<tr>
							<td colspan="12" class="text-center">
								<button class="btn btn-success" onclick="añadirUsuario()">Añadir nuevo usuario</button>
							</td>
						</tr>
					</tfoot>
				<?php endif; ?>
			</table>
		</div>
	</div>
	<datalist id="listaPaises">
		<option value="Afganistán">
		<option value="Albania">
		<option value="Alemania">
		<option value="Andorra">
		<option value="Angola">
		<option value="Antigua y Barbuda">
		<option value="Arabia Saudita">
		<option value="Argelia">
		<option value="Argentina">
		<option value="Armenia">
		<option value="Australia">
		<option value="Austria">
		<option value="Azerbaiyán">
		<option value="Bahamas">
		<option value="Bangladés">
		<option value="Barbados">
		<option value="Baréin">
		<option value="Bélgica">
		<option value="Belice">
		<option value="Benín">
		<option value="Bielorrusia">
		<option value="Birmania">
		<option value="Bolivia">
		<option value="Bosnia y Herzegovina">
		<option value="Botsuana">
		<option value="Brasil">
		<option value="Brunéi">
		<option value="Bulgaria">
		<option value="Burkina Faso">
		<option value="Burundi">
		<option value="Bután">
		<option value="Cabo Verde">
		<option value="Camboya">
		<option value="Camerún">
		<option value="Canadá">
		<option value="Catar">
		<option value="Chad">
		<option value="Chile">
		<option value="China">
		<option value="Chipre">
		<option value="Ciudad del Vaticano">
		<option value="Colombia">
		<option value="Comoras">
		<option value="Corea del Norte">
		<option value="Corea del Sur">
		<option value="Costa de Marfil">
		<option value="Costa Rica">
		<option value="Croacia">
		<option value="Cuba">
		<option value="Dinamarca">
		<option value="Dominica">
		<option value="Ecuador">
		<option value="Egipto">
		<option value="El Salvador">
		<option value="Emiratos Árabes Unidos">
		<option value="Eritrea">
		<option value="Eslovaquia">
		<option value="Eslovenia">
		<option value="España">
		<option value="Estados Unidos">
		<option value="Estonia">
		<option value="Etiopía">
		<option value="Filipinas">
		<option value="Finlandia">
		<option value="Fiyi">
		<option value="Francia">
		<option value="Gabón">
		<option value="Gambia">
		<option value="Georgia">
		<option value="Ghana">
		<option value="Granada">
		<option value="Grecia">
		<option value="Guatemala">
		<option value="Guyana">
		<option value="Guinea">
		<option value="Guinea ecuatorial">
		<option value="Guinea-Bisáu">
		<option value="Haití">
		<option value="Honduras">
		<option value="Hungría">
		<option value="India">
		<option value="Indonesia">
		<option value="Irak">
		<option value="Irán">
		<option value="Irlanda">
		<option value="Islandia">
		<option value="Islas Marshall">
		<option value="Islas Salomón">
		<option value="Israel">
		<option value="Italia">
		<option value="Jamaica">
		<option value="Japón">
		<option value="Jordania">
		<option value="Kazajistán">
		<option value="Kenia">
		<option value="Kirguistán">
		<option value="Kiribati">
		<option value="Kuwait">
		<option value="Laos">
		<option value="Lesoto">
		<option value="Letonia">
		<option value="Líbano">
		<option value="Liberia">
		<option value="Libia">
		<option value="Liechtenstein">
		<option value="Lituania">
		<option value="Luxemburgo">
		<option value="Macedonia del Norte">
		<option value="Madagascar">
		<option value="Malasia">
		<option value="Malaui">
		<option value="Maldivas">
		<option value="Malí">
		<option value="Malta">
		<option value="Marruecos">
		<option value="Mauricio">
		<option value="Mauritania">
		<option value="México">
		<option value="Micronesia">
		<option value="Moldavia">
		<option value="Mónaco">
		<option value="Mongolia">
		<option value="Montenegro">
		<option value="Mozambique">
		<option value="Namibia">
		<option value="Nauru">
		<option value="Nepal">
		<option value="Nicaragua">
		<option value="Níger">
		<option value="Nigeria">
		<option value="Noruega">
		<option value="Nueva Zelanda">
		<option value="Omán">
		<option value="Países Bajos">
		<option value="Pakistán">
		<option value="Palaos">
		<option value="Panamá">
		<option value="Papúa Nueva Guinea">
		<option value="Paraguay">
		<option value="Perú">
		<option value="Polonia">
		<option value="Portugal">
		<option value="Reino Unido">
		<option value="República Centroafricana">
		<option value="República Checa">
		<option value="República del Congo">
		<option value="República Democrática del Congo">
		<option value="República Dominicana">
		<option value="Ruanda">
		<option value="Rumanía">
		<option value="Rusia">
		<option value="Samoa">
		<option value="San Cristóbal y Nieves">
		<option value="San Marino">
		<option value="San Vicente y las Granadinas">
		<option value="Santa Lucía">
		<option value="Santo Tomé y Príncipe">
		<option value="Senegal">
		<option value="Serbia">
		<option value="Seychelles">
		<option value="Sierra Leona">
		<option value="Singapur">
		<option value="Siria">
		<option value="Somalia">
		<option value="Sri Lanka">
		<option value="Suazilandia">
		<option value="Sudáfrica">
		<option value="Sudán">
		<option value="Sudán del Sur">
		<option value="Suecia">
		<option value="Suiza">
		<option value="Surinam">
		<option value="Tailandia">
		<option value="Tanzania">
		<option value="Tayikistán">
		<option value="Timor Oriental">
		<option value="Togo">
		<option value="Tonga">
		<option value="Trinidad y Tobago">
		<option value="Túnez">
		<option value="Turkmenistán">
		<option value="Turquía">
		<option value="Tuvalu">
		<option value="Ucrania">
		<option value="Uganda">
		<option value="Uruguay">
		<option value="Uzbekistán">
		<option value="Vanuatu">
		<option value="Venezuela">
		<option value="Vietnam">
		<option value="Yemen">
		<option value="Yibuti">
		<option value="Zambia">
		<option value="Zimbabue">
	</datalist>
	<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<form id="addForm" action="añadirusuario.php" method="post">
					<div class="modal-header d-flex justify-content-between">
						<h5 class="modal-title" id="addModalLabel">Añadir usuario</h5>
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
					</div>
					<div class="modal-body">
						<div class="form-floating">
							<input name="nombre" type="text" class="form-control" id="addNombre" placeholder="" required>
							<label for="addNombre">Nombre</label>
						</div>
						<div class="form-floating">
							<input name="apellidos" type="text" class="form-control" id="addApellidos" placeholder="" required>
							<label for="addApellidos">Apellidos</label>
						</div>
						<div class="form-floating">
							<input name="direccion" type="text" class="form-control" id="addDireccion" placeholder="" required>
							<label for="addDireccion">Dirección</label>
						</div>
						<div class="form-floating">
							<input name="ciudad" type="text" class="form-control" id="addCiudad" placeholder="" required>
							<label for="addCiudad">Ciudad</label>
						</div>
						<div class="form-floating">
							<input name="provincia" type="text" class="form-control" id="addProvincia" placeholder="" required>
							<label for="addProvincia">Provincia</label>
						</div>
						<div class="form-floating">
							<input name="pais" class="form-select py-4" list="listaPaises" id="addPais" placeholder="Escribe aquí..." required>
						</div>
						<div class="form-floating">
							<input name="correo" type="email" class="form-control" id="addCorreo" placeholder="" required>
							<label for="addCorreo">Correo</label>
						</div>
						<div class="form-floating">
							<input name="contraseña" type="password" class="form-control" id="addContraseña" placeholder="" required>
							<label for="addContraseña">Contraseña</label>
						</div>
						<select name="rol" class="form-select py-3" aria-label="Selecciona el rol">
							<option selected disabled>Selecciona el rol</option>
							<option value="1">Administrador</option>
							<option value="2">Staff</option>
							<option value="3">Miembro</option>
						</select>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-success">Añadir usuario</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-labelledby="showModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header d-flex justify-content-between">
					<h5 class="modal-title" id="showModalLabel">Editar usuario</h5>
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
				</div>
				<div class="modal-body">
					<input type="number" id="showId" name="id" hidden>
					<div class="form-floating">
						<input name="nombre" type="text" class="form-control" id="showNombre" placeholder="" disabled>
						<label for="showNombre">Nombre</label>
					</div>
					<div class="form-floating">
						<input name="apellidos" type="text" class="form-control" id="showApellidos" placeholder="" disabled>
						<label for="showApellidos">Apellidos</label>
					</div>
					<div class="form-floating">
						<input name="direccion" type="text" class="form-control" id="showDireccion" placeholder="" disabled>
						<label for="showDireccion">Dirección</label>
					</div>
					<div class="form-floating">
						<input name="ciudad" type="text" class="form-control" id="showCiudad" placeholder="" disabled>
						<label for="showCiudad">Ciudad</label>
					</div>
					<div class="form-floating">
						<input name="provincia" type="text" class="form-control" id="showProvincia" placeholder="" disabled>
						<label for="showProvincia">Provincia</label>
					</div>
					<div class="form-floating">
						<input name="pais" type="text" class="form-select py-4" id="showPais" placeholder="Escribe aquí..." disabled>
					</div>
					<div class="form-floating">
						<input name="correo" type="email" class="form-control" id="showCorreo" placeholder="" disabled>
						<label for="showCorreo">Correo</label>
					</div>
						<select name="rol" id="showRol" class="form-select py-3" aria-label="Selecciona el rol" disabled>
							<option selected disabled>Selecciona el rol</option>
							<option value="1">Administrador</option>
							<option value="2">Staff</option>
							<option value="3">Miembro</option>
						</select>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<form id="editForm" action="editarusuario.php" method="post">
					<div class="modal-header d-flex justify-content-between">
						<h5 class="modal-title" id="editModalLabel">Editar usuario</h5>
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
					</div>
					<div class="modal-body">
						<input type="number" id="editId" name="id" hidden>
						<div class="form-floating">
							<input name="nombre" type="text" class="form-control" id="editNombre" placeholder="" required>
							<label for="editNombre">Nombre</label>
						</div>
						<div class="form-floating">
							<input name="apellidos" type="text" class="form-control" id="editApellidos" placeholder="" required>
							<label for="editApellidos">Apellidos</label>
						</div>
						<div class="form-floating">
							<input name="direccion" type="text" class="form-control" id="editDireccion" placeholder="" required>
							<label for="editDireccion">Dirección</label>
						</div>
						<div class="form-floating">
							<input name="ciudad" type="text" class="form-control" id="editCiudad" placeholder="" required>
							<label for="editCiudad">Ciudad</label>
						</div>
						<div class="form-floating">
							<input name="provincia" type="text" class="form-control" id="editProvincia" placeholder="" required>
							<label for="editProvincia">Provincia</label>
						</div>
						<div class="form-floating">
							<input name="pais" class="form-select py-4" list="listaPaises" id="editPais" placeholder="Escribe aquí..." required>
						</div>
						<div class="form-floating">
							<input name="correo" type="email" class="form-control" id="editCorreo" placeholder="" required>
							<label for="editCorreo">Correo</label>
						</div>
						<select name="rol" id="editRol" class="form-select py-3" aria-label="Selecciona el rol">
							<option selected disabled>Selecciona el rol</option>
							<option value="1">Administrador</option>
							<option value="2">Staff</option>
							<option value="3">Miembro</option>
						</select>
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
				<form id="deleteForm" action="borrarusuario.php" method="post">
					<div class="modal-header d-flex justify-content-between">
						<h5 class="modal-title" id="deleteModalLabel">Borrar usuario</h5>
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
					</div>
					<div class="modal-body">
						<input type="number" id="deleteId" name="id" hidden>
						<h6>Estás a punto de borrar el usuario <span id="deleteCorreo"></span>. Esta acción no se puede deshacer.</h6>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-danger">Borrar usuario</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
	function añadirUsuario() {
		const modal = new bootstrap.Modal(document.querySelector('#addModal'));
		modal.show();
	}

	function mostrarUsuario(id, nombre, apellidos, direccion, ciudad, provincia, pais, correo, rol) {
		document.querySelector('#showId').value = id;
		document.querySelector('#showNombre').value = nombre;
		document.querySelector('#showApellidos').value = apellidos;
		document.querySelector('#showDireccion').value = direccion;
		document.querySelector('#showCiudad').value = ciudad;
		document.querySelector('#showProvincia').value = provincia;
		document.querySelector('#showPais').value = pais;
		document.querySelector('#showCorreo').value = correo;
		document.querySelector('#showRol').value = rol;
		const modal = new bootstrap.Modal(document.querySelector('#showModal'));
		modal.show();
	}

	function editarUsuario(id, nombre, apellidos, direccion, ciudad, provincia, pais, correo, rol) {
		document.querySelector('#editId').value = id;
		document.querySelector('#editNombre').value = nombre;
		document.querySelector('#editApellidos').value = apellidos;
		document.querySelector('#editDireccion').value = direccion;
		document.querySelector('#editCiudad').value = ciudad;
		document.querySelector('#editProvincia').value = provincia;
		document.querySelector('#editPais').value = pais;
		document.querySelector('#editCorreo').value = correo;
		document.querySelector('#editRol').value = rol;
		const modal = new bootstrap.Modal(document.querySelector('#editModal'));
		modal.show();
	}

	function borrarUsuario(id, correo) {
		document.querySelector('#deleteId').value = id;
		document.querySelector('#deleteCorreo').textContent = correo;
		const modal = new bootstrap.Modal(document.querySelector('#deleteModal'));
		modal.show();
	}
</script>
<?php include_once 'footer.php'; ?>