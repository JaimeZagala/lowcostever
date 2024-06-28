<?php
include_once 'header.php';
if(isset($_SESSION['usuario'])) {
	header('location: dashboard.php');
	exit;
}
if($_SERVER['REQUEST_METHOD'] === 'POST') {
	include_once 'connection.php';
	try {
		$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
		$sqlInsert = $db->prepare('INSERT INTO usuarios (id, nombre, apellidos, direccion, ciudad, provincia, pais, correo, password) VALUES (NULL, :nombre, :apellidos, :direccion, :ciudad, :provincia, :pais, :correo, :password)');
		$sqlInsert->bindParam(':nombre', $_POST['nombre'], PDO::PARAM_STR);
		$sqlInsert->bindParam(':apellidos', $_POST['apellidos'], PDO::PARAM_STR);
		$sqlInsert->bindParam(':direccion', $_POST['direccion'], PDO::PARAM_STR);
		$sqlInsert->bindParam(':ciudad', $_POST['ciudad'], PDO::PARAM_STR);
		$sqlInsert->bindParam(':provincia', $_POST['provincia'], PDO::PARAM_STR);
		$sqlInsert->bindParam(':pais', $_POST['pais'], PDO::PARAM_STR);
		$sqlInsert->bindParam(':correo', $_POST['correo'], PDO::PARAM_STR);
		$sqlInsert->bindParam(':password', $password, PDO::PARAM_STR);
		$sqlInsert->execute();
		$db = null;
	} catch (PDOException $e) {
		echo "Error al insertar datos: " . $e->getMessage();
	}
	header('location: login.php');
	exit;
}
?>
<div class="container col text-center col-md-6 my-5">
	<img class="mx-auto my-4" src="images/lowcost.png" alt="" width="25%">
</div>
<div class="container col-md-6 my-4">
	<form action="registro.php" method="post">
		<h1 class="h3 mb-3 fw-normal text-center">Registrar</h1>
		<div class="form-floating">
			<input name="nombre" type="text" class="form-control" id="floatingNombre" placeholder="Nombre">
			<label for="floatingNombre">Nombre</label>
		</div>
		<div class="form-floating">
			<input name="apellidos" type="text" class="form-control" id="floatingApellidos" placeholder="Apellidos">
			<label for="floatingApellidos">Apellidos</label>
		</div>
		<div class="form-floating">
			<input name="direccion" type="text" class="form-control" id="floatingDireccion" placeholder="Direccion">
			<label for="floatingDireccion">Dirección</label>
		</div>
		<div class="form-floating">
			<input name="ciudad" type="text" class="form-control" id="floatingCiudad" placeholder="Ciudad">
			<label for="floatingCiudad">Ciudad</label>
		</div>
		<div class="form-floating">
			<input name="provincia" type="text" class="form-control" id="floatingProvincia" placeholder="Provincia">
			<label for="floatingProvincia">Provincia</label>
		</div>
		<div class="form-floating">
			<input name="pais" class="form-select py-4 text-black" list="listaPaises" id="addPais" placeholder="País" required>
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
		</div>
		<div class="form-floating">
			<input name="correo" type="email" class="form-control" id="floatingCorreo" placeholder="Correo">
			<label for="floatingCorreo">Correo</label>
		</div>
		<div class="form-floating">
			<input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Contraseña">
			<label for="floatingPassword">Contraseña</label>
		</div>
		<button class="btn btn-primary w-100 py-2" type="submit">Completar registro</button>
	</form>
</div>
<?php include_once 'footer.php'; ?>